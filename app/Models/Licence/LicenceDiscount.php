<?php

declare(strict_types=1);

namespace App\Models\Licence;

use App\Enums\LicenceDiscountType;
use App\Models\Meta\Season;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LicenceDiscount extends Model
{
    use Blamable, HasUlids;

    protected $table = 'licence_discounts';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'type',
        'amount',
        'licence_id',
        'season_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => LicenceDiscountType::class,
            'amount' => MoneyIntegerCast::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (LicenceDiscount $licenceDiscount) {
            $licenceDiscount->season_id = Season::current()->first()->id;
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

    /** @return BelongsTo<Licence> */
    public function licence(): BelongsTo
    {
        return $this->belongsTo(Licence::class, 'licence_id', 'id', 'licenceDiscounts');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getNameAttribute(): string
    {
        return sprintf('%s (%s)', $this->type->getLabel(), $this->amount);
    }
}
