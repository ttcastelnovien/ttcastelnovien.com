<?php

namespace App\Models\Accounting;

use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalyticAccountEntry extends Model
{
    use Blamable, HasUlids;

    protected $table = 'analytic_account_entry';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'analytic_account_id',
        'journal_entry_id',
        'amount',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'amount' => MoneyIntegerCast::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<JournalEntry> */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    /** @return BelongsTo<AnalyticAccount> */
    public function analyticAccount(): BelongsTo
    {
        return $this->belongsTo(AnalyticAccount::class);
    }
}
