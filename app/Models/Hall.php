<?php

namespace App\Models;

use Database\Factories\HallFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hall extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    /** @use HasFactory<HallFactory> */
    use HasFactory, HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'postal_code',
        'city',
        'latitude',
        'longitude',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<Club> */
    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
}
