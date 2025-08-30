<?php

namespace App\Models\Accounting;

use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnalyticAccount extends Model
{
    use Blamable, HasUlids;

    protected $table = 'analytic_accounts';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'balance',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'balance' => MoneyIntegerCast::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return HasMany<AnalyticAccountEntry> */
    public function entries(): HasMany
    {
        return $this->hasMany(AnalyticAccountEntry::class);
    }
}
