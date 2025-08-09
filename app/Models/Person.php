<?php

namespace App\Models;

use App\Enums\Sex;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<PersonFactory> */
    use HasFactory, HasUlids;

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
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'sex' => Sex::class,
            'birth_date' => 'date',
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

    /** @return BelongsToMany<Season, self, Licence> */
    public function seasons(): BelongsToMany
    {
        return $this->belongsToMany(Season::class)->using(Licence::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function fullName(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

    public function isMinor(): bool
    {
        return $this->birth_date->isFuture() || $this->birth_date->diffInYears(now()) < 18;
    }
}
