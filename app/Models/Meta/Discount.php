<?php

declare(strict_types=1);

namespace App\Models\Meta;

use App\Enums\LicenceDiscountType;
use App\Models\Licence\Licence;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyStringCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discount extends Model
{
    use Blamable, HasUlids;

    protected $table = 'discounts';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'type',
        'amount',
        'season_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => LicenceDiscountType::class,
            'amount' => MoneyStringCast::class,
        ];
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

    /** @return BelongsToMany<Licence> */
    public function licences(): BelongsToMany
    {
        return $this->belongsToMany(Licence::class);
    }
}
