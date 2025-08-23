<?php

namespace App\Models\Communication;

use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use Database\Factories\Communication\GroupFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<GroupFactory> */
    use HasFactory, HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'color',
        'season_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Group $group) {
            $group->season_id = Season::current()->first()->id;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return HasMany<Event> */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /** @return BelongsToMany<Person> */
    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    /** @return BelongsTo<Season> */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}
