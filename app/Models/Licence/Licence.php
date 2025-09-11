<?php

declare(strict_types=1);

namespace App\Models\Licence;

use App\Enums\LicenceCategory;
use App\Enums\LicenceDocumentStatus;
use App\Enums\LicenceType;
use App\Models\Accounting\SupportingDocument;
use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Licence extends Pivot
{
    use Blamable, HasUlids;

    protected $table = 'licences';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        /** Informations sur la personne */
        'firstname',
        'lastname',
        /** Informations sur la licence */
        'type',
        'category',
        'is_minor',
        /** Documents */
        'needs_image_rights',
        'needs_exit_authorization',
        'needs_care_authorization',
        'needs_transport_authorization',
        'needs_medical_certificate',
        'needs_health_declaration',
        'has_image_rights',
        'has_exit_authorization',
        'has_care_authorization',
        'has_transport_authorization',
        'has_medical_certificate',
        'has_health_declaration',
        /** Suivi administratif */
        'validated',
        'observations',
        /** Suivi trésorerie */
        'amount',
        'discounted_amount',
        /** Relations */
        'invoice_id',
        'person_id',
        'season_id',
        'licence_fee_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => LicenceType::class,
            'category' => LicenceCategory::class,
            'is_minor' => 'boolean',
            'validated' => 'boolean',
            'needs_image_rights' => 'boolean',
            'needs_exit_authorization' => 'boolean',
            'needs_care_authorization' => 'boolean',
            'needs_transport_authorization' => 'boolean',
            'needs_medical_certificate' => 'boolean',
            'needs_health_declaration' => 'boolean',
            'has_image_rights' => 'boolean',
            'has_exit_authorization' => 'boolean',
            'has_care_authorization' => 'boolean',
            'has_transport_authorization' => 'boolean',
            'has_medical_certificate' => 'boolean',
            'has_health_declaration' => 'boolean',
            'amount' => MoneyIntegerCast::class,
            'discounted_amount' => MoneyIntegerCast::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Licence $licence) {
            $licence->firstname = $licence->person->firstname;
            $licence->lastname = $licence->person->lastname;

            $season = Season::current()->first();
            $licence->season_id = $season->id;

            $licence->category = LicenceCategory::fromBirthDate($licence->person->birth_date, $licence->season);
            $licence->is_minor = LicenceCategory::isMinorCategory($licence->category);

            $licenceFee = LicenceFee::query()
                ->whereJsonContains('licence_types', $licence->type)
                ->whereJsonContains('licence_categories', $licence->category)
                ->where('season_id', $season->id)
                ->firstOrFail();

            $licence->licence_fee_id = $licenceFee->id;
            $licence->amount = $licenceFee->price;
            $licence->discounted_amount = $licenceFee->price;

            $licence->licenceDiscounts()->each(function (LicenceDiscount $discount) use ($licence) {
                if ($discount->type->invoice_deductible) {
                    $licence->discounted_amount = $licence->discounted_amount->subtract($discount->amount);
                }
            });

            $licence->initializeImageRights();
            $licence->initializeAuthorizations();
            $licence->initializeHealthDocuments();
        });

        static::updating(function (Licence $licence) {
            $licence->discounted_amount = $licence->amount;

            $licence->licenceDiscounts()->each(function (LicenceDiscount $discount) use ($licence) {
                if ($discount->type->invoice_deductible) {
                    $licence->discounted_amount = $licence->discounted_amount->subtract($discount->amount);
                }
            });

            $licence->initializeImageRights();
            $licence->initializeAuthorizations();
            $licence->initializeHealthDocuments();
        });
    }

    public function initializeImageRights(): void
    {
        if ($this->person->last_image_rights_authorization_date) {
            $futureAuthorizationDate = $this->person->last_image_rights_authorization_date->addYears(5);
            $referenceDate = $this->season->starts_at;

            if ($futureAuthorizationDate->isAfter($referenceDate)) {
                $this->needs_image_rights = false;

                return;
            }
        }

        $this->needs_image_rights = true;
    }

    public function initializeAuthorizations(): void
    {
        $this->needs_exit_authorization = $this->person->is_minor;
        $this->needs_care_authorization = $this->person->is_minor;
        $this->needs_transport_authorization = $this->person->is_minor;
    }

    public function initializeHealthDocuments(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Si l'auto-questionnaire a été rendu, mais qu'il est positif, alors
        | il faut demander un nouveau certificat médical.
        |--------------------------------------------------------------------------
        */

        if ($this->has_health_declaration === false) {
            $this->needs_medical_certificate = true;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Si le dernier certificat médical connu date d'après le début
        | de la saison en cours, on ne demande pas l'auto-questionnaire.
        |--------------------------------------------------------------------------
        */

        $lastCertificate = $this->person->medicalCertificates()->latest()->first();
        $lastCertificateDate = $lastCertificate?->date;

        if ($lastCertificateDate !== null && $lastCertificateDate->isAfter($this->season->starts_at)) {
            $this->needs_medical_certificate = false;
            $this->needs_health_declaration = false;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | On récupère la catégorie de licence de la saison en cours.
        |--------------------------------------------------------------------------
        */

        $licenceCategory = LicenceCategory::fromBirthDate($this->person->birth_date, $this->season);

        /*
        |--------------------------------------------------------------------------
        | Si la personne est dans une autre catégorie que vétéran, elle
        | n'a pas besoin de présenter de certificat médical.
        |--------------------------------------------------------------------------
        */

        if (
            LicenceCategory::isInferiorCategory(
                reference: $licenceCategory,
                target: LicenceCategory::SENIOR,
                inclusive: true,
            )
        ) {
            $this->needs_medical_certificate = false;
            $this->needs_health_declaration = true;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Si c'est une première licence pour la personne, le certificat médical
        | est obligatoire.
        |--------------------------------------------------------------------------
        */

        $previousSeason = $this->season->previousSeason()->first();

        if ($previousSeason === null) {
            $this->needs_medical_certificate = true;
            $this->needs_health_declaration = false;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Si c'est une personne vétéran, on vérifie si sa catégorie d'âge
        | a évolué entre la saison précédente et la saison en cours. Si c'est
        | le cas, on demande un nouveau certificat médical.
        |--------------------------------------------------------------------------
        */

        $previousCategory = LicenceCategory::fromBirthDate($this->person->birth_date, $previousSeason);

        if ($previousCategory !== $licenceCategory) {
            $this->needs_medical_certificate = true;
            $this->needs_health_declaration = false;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | On vérifie si la personne possédait déjà un certificat médical
        | lors des saisons précédentes.
        | Si la date du dernier certificat médical + 5 ans est postérieure
        | à la date de début de la saison en cours, l'auto-questionnaire
        | de santé suffit au renouvellement de licence.
        |--------------------------------------------------------------------------
        */

        if ($lastCertificateDate !== null && $lastCertificateDate->addYears(5)->isAfter($this->season->starts_at)) {
            $this->needs_medical_certificate = false;
            $this->needs_health_declaration = true;

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Sinon on demande un nouveau certificat médical.
        |--------------------------------------------------------------------------
        */

        $this->needs_medical_certificate = true;
        $this->needs_health_declaration = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<Person> */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /** @return BelongsTo<Season> */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /** @return BelongsTo<SupportingDocument> */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(SupportingDocument::class, 'invoice_id');
    }

    /** @return BelongsTo<LicenceFee> */
    public function licenceFee(): BelongsTo
    {
        return $this->belongsTo(LicenceFee::class);
    }

    /** @return HasMany<LicenceDiscount> */
    public function licenceDiscounts(): HasMany
    {
        return $this->hasMany(LicenceDiscount::class, 'licence_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getImageRightsAttribute(): LicenceDocumentStatus
    {
        if ($this->needs_image_rights === false) {
            return LicenceDocumentStatus::NOT_NECESSARY;
        }

        if (is_null($this->has_image_rights)) {
            return LicenceDocumentStatus::PENDING;
        }

        if (! $this->has_image_rights) {
            return LicenceDocumentStatus::REJECTED;
        }

        return LicenceDocumentStatus::ACCEPTED;
    }

    public function getExitAuthorizationAttribute(): LicenceDocumentStatus
    {
        if ($this->needs_exit_authorization === false) {
            return LicenceDocumentStatus::NOT_NECESSARY;
        }

        if (is_null($this->has_exit_authorization)) {
            return LicenceDocumentStatus::PENDING;
        }

        if (! $this->has_exit_authorization) {
            return LicenceDocumentStatus::REJECTED;
        }

        return LicenceDocumentStatus::ACCEPTED;
    }

    public function getCareAuthorizationAttribute(): LicenceDocumentStatus
    {
        if ($this->needs_care_authorization === false) {
            return LicenceDocumentStatus::NOT_NECESSARY;
        }

        if (is_null($this->has_care_authorization)) {
            return LicenceDocumentStatus::PENDING;
        }

        if (! $this->has_care_authorization) {
            return LicenceDocumentStatus::REJECTED;
        }

        return LicenceDocumentStatus::ACCEPTED;
    }

    public function getTransportAuthorizationAttribute(): LicenceDocumentStatus
    {
        if ($this->needs_transport_authorization === false) {
            return LicenceDocumentStatus::NOT_NECESSARY;
        }

        if (is_null($this->has_transport_authorization)) {
            return LicenceDocumentStatus::PENDING;
        }

        if (! $this->has_transport_authorization) {
            return LicenceDocumentStatus::REJECTED;
        }

        return LicenceDocumentStatus::ACCEPTED;
    }

    public function getMedicalCertificateAttribute(): LicenceDocumentStatus
    {
        if ($this->needs_medical_certificate === false) {
            return LicenceDocumentStatus::NOT_NECESSARY;
        }

        if (is_null($this->has_medical_certificate)) {
            return LicenceDocumentStatus::PENDING;
        }

        if (! $this->has_medical_certificate) {
            return LicenceDocumentStatus::REJECTED;
        }

        return LicenceDocumentStatus::ACCEPTED;
    }

    public function getHealthDeclarationAttribute(): LicenceDocumentStatus
    {
        if ($this->needs_health_declaration === false) {
            return LicenceDocumentStatus::NOT_NECESSARY;
        }

        if (is_null($this->has_health_declaration)) {
            return LicenceDocumentStatus::PENDING;
        }

        if (! $this->has_health_declaration) {
            return LicenceDocumentStatus::REJECTED;
        }

        return LicenceDocumentStatus::ACCEPTED;
    }

    public function getRemainingAmountAttribute(): string
    {
        $price = $this->amount;

        $this->licenceDiscounts()->each(function (LicenceDiscount $discount) use (&$price) {
            $price = $price->subtract($discount->amount);
        });

        return $price->formatByIntl();
    }
}
