<?php

namespace App\Models\Accounting;

use App\Models\Traits\Blamable;
use App\Services\OFXParser\Enums\TransactionType;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankTransaction extends Model
{
    use Blamable, HasUlids;

    protected $table = 'bank_transactions';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'date',
        'type',
        'name',
        'description',
        'credit',
        'debit',
        'reference',
        'reconciled',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'date' => 'date',
            'type' => TransactionType::class,
            'credit' => MoneyIntegerCast::class,
            'debit' => MoneyIntegerCast::class,
            'reconciled' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<SupportingDocument> */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(SupportingDocument::class);
    }

    /** @return HasMany<AnalyticAccountEntry> */
    public function analyticAccountsEntries(): HasMany
    {
        return $this->hasMany(AnalyticAccountEntry::class);
    }

    /** @return BelongsTo<LedgerAccount> */
    public function ledgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'ledger_account_id');
    }

    /** @return BelongsTo<Journal> */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    /** @return BelongsTo<LedgerAccount> */
    public function clientLedgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'client_ledger_account_id');
    }

    /** @return BelongsTo<LedgerAccount> */
    public function supplierLedgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'supplier_ledger_account_id');
    }

    /** @return BelongsTo<SupportingDocument> */
    public function supportingDocument(): BelongsTo
    {
        return $this->belongsTo(SupportingDocument::class, 'supporting_document_id');
    }
}
