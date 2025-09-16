<?php

namespace App\Models\HumanResource;

use App\Enums\ClothingSize;
use App\Enums\LicenceCategory;
use App\Enums\Sex;
use App\Models\Accounting\LedgerAccount;
use App\Models\Communication\Event;
use App\Models\Communication\Group;
use App\Models\Licence\Licence;
use App\Models\Licence\LicenceFee;
use App\Models\Licence\MedicalCertificate;
use App\Models\Security\User;
use App\Models\Traits\Blamable;
use Database\Factories\HumanResource\PersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<PersonFactory> */
    use Blamable, HasFactory, HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'firstname',
        'lastname',
        'sex',
        'birth_name',
        'birth_date',
        'birth_city',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'postal_code',
        'city',
        'licence_number',
        'nationality',
        'father_name',
        'mother_name',
        'clothing_size',
        'pants_size',
        'last_image_rights_authorization_date',
        'client_ledger_account_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'sex' => Sex::class,
            'birth_date' => 'date',
            'last_image_rights_authorization_date' => 'date',
            'clothing_size' => ClothingSize::class,
            'pants_size' => ClothingSize::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Person $person) {
            $parentAccount = LedgerAccount::query()->whereCode('4111000')->firstOrFail();
            $personFullname = mb_strtoupper($person->lastname).' '.$person->firstname;

            $ledgerAccount = LedgerAccount::query()->createOrFirst(
                attributes: ['name' => $personFullname],
                values: [
                    'name' => $personFullname,
                    'code' => LedgerAccount::nextAccountCode($parentAccount),
                    'parent_id' => $parentAccount->id,
                ],
            );

            $person->client_ledger_account_id = $ledgerAccount->id;
        });

        static::updating(function (Person $person) {
            if ($person->isDirty('birth_date')) {
                $person->licences()->get()->each(function (Licence $licence) {
                    $licence->category = LicenceCategory::fromBirthDate($licence->person->birth_date, $licence->season);
                    $licence->is_minor = LicenceCategory::isMinorCategory($licence->category);

                    $licenceFee = LicenceFee::query()
                        ->whereJsonContains('licence_types', $licence->licence_type)
                        ->whereJsonContains('licence_categories', $licence->category)
                        ->where('season_id', $licence->season->id)
                        ->firstOrFail();

                    $licence->licence_fee_id = $licenceFee->id;
                    $licence->save();
                });
            }

            if ($person->isDirty(['firstname', 'lastname'])) {
                $person->licences()->get()->each(function (Licence $licence) use ($person) {
                    $licence->firstname = $person->firstname;
                    $licence->lastname = $person->lastname;
                    $licence->save();
                });

                $ledgerAccount = $person->clientLedgerAccount;
                $ledgerAccount->name = $person->lastname_firstname;
                $ledgerAccount->save();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return HasOne<User> */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /** @return HasMany<Licence> */
    public function licences(): HasMany
    {
        return $this->hasMany(Licence::class);
    }

    /** @return BelongsToMany<Person> */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Person::class,
            table: 'child_parent',
            foreignPivotKey: 'child_id',
            relatedPivotKey: 'parent_id',
        );
    }

    /** @return BelongsToMany<Person> */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(
            related: Person::class,
            table: 'child_parent',
            foreignPivotKey: 'parent_id',
            relatedPivotKey: 'child_id',
        );
    }

    /** @return HasMany<MedicalCertificate> */
    public function medicalCertificates(): HasMany
    {
        return $this->hasMany(MedicalCertificate::class);
    }

    /** @return BelongsToMany<Event> */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    /** @return BelongsToMany<Group> */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /** @return BelongsTo<LedgerAccount> */
    public function clientLedgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'client_ledger_account_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getIsMinorAttribute(): bool
    {
        return $this->birth_date->isFuture() || $this->birth_date->diffInYears(now()) < 18;
    }

    public function getFullAddressAttribute(): string
    {
        $addressParts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->address_line_3,
            "$this->postal_code $this->city",
        ];

        return implode('<br>', array_filter($addressParts));
    }
}
