<?php

namespace App\Models\Invoicing;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\HumanResource\Person;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use Blamable, HasUlids;

    protected $table = 'invoices';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'reference',
        'total_amount',
        'date',
        'due_date',
        'paid_at',
        'payment_method',
        'payment_reference',
        'payment_status',
        'file',
        'comment',
        'person_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'total_amount' => MoneyIntegerCast::class,
            'date' => 'date',
            'due_date' => 'date',
            'paid_at' => 'date',
            'payment_method' => PaymentMethod::class,
            'payment_status' => PaymentStatus::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<Person> */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /** @return HasMany<InvoiceLine> */
    public function lines(): HasMany
    {
        return $this->hasMany(InvoiceLine::class);
    }
}
