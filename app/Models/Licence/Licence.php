<?php

declare(strict_types=1);

namespace App\Models\Licence;

use App\Enums\LicenceCategory;
use App\Enums\LicenceType;
use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use App\Models\Traits\Blamable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Collection;

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
        /** Informations sur la licence */
        'licence_type',
        'has_image_rights',
        'has_exit_authorization',
        'has_care_authorization',
        'has_transport_authorization',
        'has_medical_certificate',
        'has_health_declaration',
        /** Suivi administratif */
        'validated',
        'observations',
        /** Relations */
        'person_id',
        'season_id',
        'licence_fee_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'licence_type' => LicenceType::class,
            'has_image_rights' => 'boolean',
            'has_exit_authorization' => 'boolean',
            'has_care_authorization' => 'boolean',
            'has_transport_authorization' => 'boolean',
            'has_medical_certificate' => 'boolean',
            'has_health_declaration' => 'boolean',
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
            $season = Season::current()->first();
            $licence->season_id = $season->id;

            $licenceFee = LicenceFee::query()
                ->whereJsonContains('licence_types', $licence->licence_type)
                ->whereJsonContains('licence_categories', $licence->category)
                ->where('season_id', $season->id)
                ->firstOrFail();

            $licence->licence_fee_id = $licenceFee->id;
        });
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

    public function getFullNameAttribute(): string
    {
        return $this->person->full_name;
    }

    public function getCategoryAttribute(): LicenceCategory
    {
        return LicenceCategory::fromBirthDate($this->person->birth_date, $this->season);
    }

    public function getImageRightsAttribute(): ?bool
    {
        if ($this->person->last_image_rights_authorization_date) {
            $futureAuthorizationDate = $this->person->last_image_rights_authorization_date->addYears(5);
            $referenceDate = $this->season->starts_at;

            if ($futureAuthorizationDate->isAfter($referenceDate)) {
                return null;
            }
        }

        return $this->has_image_rights;
    }

    public function getExitAuthorizationAttribute(): ?bool
    {
        if (! $this->person->is_minor) {
            return null;
        }

        return $this->has_exit_authorization;
    }

    public function getCareAuthorizationAttribute(): ?bool
    {
        if (! $this->person->is_minor) {
            return null;
        }

        return $this->has_care_authorization;
    }

    public function getTransportAuthorizationAttribute(): ?bool
    {
        if (! $this->person->is_minor) {
            return null;
        }

        return $this->has_transport_authorization;
    }

    public function getMedicalCertificateAttribute(): ?bool
    {
        /*
        |--------------------------------------------------------------------------
        | Si le dernier certificat médical connu date d'après le début
        | de la saison en cours, on ne demande pas l'auto-questionnaire.
        |--------------------------------------------------------------------------
        */

        $lastCertificate = $this->person->medicalCertificates()->latest()->first();
        $lastCertificateDate = $lastCertificate?->date;

        if ($lastCertificateDate !== null && $lastCertificateDate->isAfter($this->season->starts_at)) {
            return true;
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
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Si c'est une première licence pour la personne, le certificat médical
        | est obligatoire.
        |--------------------------------------------------------------------------
        */

        $previousSeason = $this->season->previousSeason()->first();

        if ($previousSeason === null) {
            return $this->has_medical_certificate;
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
            return $this->has_medical_certificate;
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
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Sinon on demande un nouveau certificat médical.
        |--------------------------------------------------------------------------
        */

        return $this->has_medical_certificate;
    }

    public function getHealthDeclarationAttribute(): ?bool
    {
        if ($this->has_health_declaration === null) {
            return $this->has_health_declaration;
        }

        /*
        |--------------------------------------------------------------------------
        | Si un certificat médical est nécessaire, on ne demande pas
        | l'auto-questionnaire de santé.
        |--------------------------------------------------------------------------
        */

        if ($this->medical_certificate !== null) {
            return null;
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
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | Sinon l'auto-questionnaire de santé annuel est obligatoire.
        |--------------------------------------------------------------------------
        */

        return $this->has_health_declaration;
    }

    public function getFinalPriceAttribute(): string
    {
        $price = $this->licenceFee->price;
        /** @var Collection<LicenceDiscount> $discounts */
        $discounts = $this->licenceDiscounts()->get();

        if ($discounts->isNotEmpty()) {
            $discounts->each(function ($discount) use (&$price) {
                $price = $price->subtract($discount->amount);
            });
        }

        return $price->formatByIntl();
    }
}
