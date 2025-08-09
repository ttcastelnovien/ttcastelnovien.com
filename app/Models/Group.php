<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }
}
