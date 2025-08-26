<?php

declare(strict_types=1);

namespace App\Models\Licence;

use App\Enums\LicenceCategory;
use App\Enums\LicenceType;
use App\Models\Meta\Season;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LicenceFee extends Model
{
    use Blamable, HasUlids;

    protected $table = 'licence_fees';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'licence_types',
        'licence_categories',
        'price',
        'season_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'licence_types' => AsEnumCollection::of(LicenceType::class),
            'licence_categories' => AsEnumCollection::of(LicenceCategory::class),
            'price' => MoneyIntegerCast::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (LicenceFee $licenceFee) {
            $licenceFee->season_id = Season::current()->first()->id;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<Season> */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /** @return HasMany<Licence> */
    public function licences(): HasMany
    {
        return $this->hasMany(Licence::class);
    }
}
