<?php

declare(strict_types=1);

namespace App\Models\Accounting;

use App\Enums\JournalType;
use App\Models\Traits\Blamable;
use Cknow\Money\Casts\MoneyIntegerCast;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use Blamable, HasUlids;

    protected $table = 'journals';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'code',
        'type',
        'start_balance',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => JournalType::class,
            'start_balance' => MoneyIntegerCast::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Lifecycle callbacks
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (Journal $journal): void {
            $journal->code = static::nextJournalCode($journal->type);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Query Builder
    |--------------------------------------------------------------------------
    */

    public static function nextJournalCode(JournalType $type): string
    {
        $result = static::query()
            ->where('code', 'like', $type->prefix().'%')
            ->max('code');

        if (is_null($result)) {
            return $type->prefix().'1';
        }

        $prevIndex = (int) str_replace($type->prefix(), '', $result);

        return $type->prefix().($prevIndex + 1);
    }
}
