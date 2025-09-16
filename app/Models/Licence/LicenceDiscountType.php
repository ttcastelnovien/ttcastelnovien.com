<?php

declare(strict_types=1);

namespace App\Models\Licence;

use App\Models\Traits\Blamable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LicenceDiscountType extends Model
{
    use Blamable, HasUlids;

    protected $table = 'licence_discount_types';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'invoice_deductible',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'invoice_deductible' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return HasMany<LicenceDiscount> */
    public function discounts(): HasMany
    {
        return $this->hasMany(LicenceDiscount::class);
    }
}
