<?php

namespace App\Models\HumanResource;

use App\Models\Accounting\LedgerAccount;
use App\Models\Traits\Blamable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    use Blamable, HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'address_line_3',
        'postal_code',
        'city',
        'supplier_ledger_account_id',
        'default_ledger_account_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Supplier $supplier) {
            $parentAccount = LedgerAccount::query()->whereCode('4011000')->firstOrFail();

            $ledgerAccount = LedgerAccount::query()->createOrFirst(
                attributes: ['name' => $supplier->name],
                values: [
                    'name' => $supplier->name,
                    'code' => LedgerAccount::nextAccountCode($parentAccount),
                    'parent_id' => $parentAccount->id,
                ],
            );

            $supplier->supplier_ledger_account_id = $ledgerAccount->id;
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<LedgerAccount> */
    public function defaultLedgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'default_ledger_account_id');
    }

    /** @return BelongsTo<LedgerAccount> */
    public function supplierLedgerAccount(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'supplier_ledger_account_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullAddressAttribute(): string
    {
        $addressParts = [
            $this->address_line_1,
            $this->address_line_2,
            $this->address_line_3,
            "$this->postal_code $this->city",
        ];

        return implode('<br>', array_filter($addressParts));
    }
}
