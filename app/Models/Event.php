<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<EventFactory> */
    use HasFactory, HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'title',
        'description',
        'at_home',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'postal_code',
        'city',
        'latitude',
        'longitude',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'opponent',
        'check_in_time',
        'departure_time',
        'attachments',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'at_home' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'start_date' => 'date',
            'end_date' => 'date',
            'attachments' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function isAllDay(): bool
    {
        return is_null($this->start_time) && is_null($this->end_time);
    }
}
