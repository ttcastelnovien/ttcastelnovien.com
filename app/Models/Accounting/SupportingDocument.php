<?php

namespace App\Models\Accounting;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\SupportingDocumentType;
use App\Models\HumanResource\Person;
use App\Models\HumanResource\Supplier;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportingDocument extends Model
{
    use Blamable, HasUlids;

    protected $table = 'supporting_documents';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'reference',
        'type',
        'total_amount',
        'date',
        'due_date',
        'paid_at',
        'payment_method',
        'payment_reference',
        'payment_status',
        'observations',
        'file',
        'journal_id',
        'person_id',
        'supplier_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => SupportingDocumentType::class,
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
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (SupportingDocument $document) {
            if ($document->total_amount->isZero()) {
                $document->payment_status = PaymentStatus::PAID;
            } else {
                $document->payment_status = PaymentStatus::WAITING;
            }
        });
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

    /** @return BelongsTo<Supplier> */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /** @return BelongsTo<Journal> */
    public function journal(): BelongsTo
    {
        return $this->belongsTo(Journal::class);
    }

    /** @return HasMany<JournalEntry> */
    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Builder
    |--------------------------------------------------------------------------
    */

    public static function nextDocumentReference(SupportingDocumentType $documentType): string
    {
        $prefix = $documentType->getPrefix();
        $dateReference = date('ym');

        $result = static::query()
            ->where('reference', 'like', $prefix.$dateReference.'%')
            ->max('reference');

        if (is_null($result)) {
            return $prefix.$dateReference.'0001';
        }

        $result = substr($result, -4);
        $result = (int) $result + 1;
        $result = str_pad($result, 4, '0', STR_PAD_LEFT);

        return $prefix.$dateReference.$result;
    }
}
