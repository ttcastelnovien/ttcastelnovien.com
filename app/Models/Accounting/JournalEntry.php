<?php

namespace App\Models\Accounting;

use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JournalEntry extends Model
{
    use Blamable, HasUlids;

    protected $table = 'journal_entries';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'date',
        'name',
        'description',
        'credit',
        'debit',
        'ledger_account_id',
        'journal_id',
        'client_ledger_account_id',
        'supplier_ledger_account_id',
        'supporting_document_id',
        'reconciled',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
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
    public function supportingDocument(): BelongsTo
    {
        return $this->belongsTo(SupportingDocument::class, 'supporting_document_id');
    }

    /** @return BelongsTo<LedgerAccount> */
    public function ledgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'ledger_account_id');
    }

    /** @return BelongsTo<Journal> */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class, 'journal_id');
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

    /** @return HasMany<AnalyticAccountEntry> */
    public function analyticAccountsEntries(): HasMany
    {
        return $this->hasMany(AnalyticAccountEntry::class);
    }

    /** @return HasMany<BankReconciliation> */
    public function bankReconciliations(): HasMany
    {
        return $this->hasMany(BankReconciliation::class);
    }
}
