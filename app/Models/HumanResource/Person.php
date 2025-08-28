<?php

namespace App\Models\HumanResource;

use App\Enums\Sex;
use App\Models\Communication\Event;
use App\Models\Communication\Group;
use App\Models\Licence\Licence;
use App\Models\Licence\MedicalCertificate;
use App\Models\Security\User;
use App\Models\Traits\Blamable;
use Database\Factories\HumanResource\PersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'first_name',
        'last_name',
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
        'last_image_rights_authorization_date',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'sex' => Sex::class,
            'birth_date' => 'date',
            'last_image_rights_authorization_date' => 'date',
        ];
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

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name).' '.trim(mb_strtoupper($this->last_name));
    }

    public function getLastnameFirstnameAttribute(): string
    {
        return trim(mb_strtoupper($this->last_name)).' '.trim($this->first_name);
    }

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
