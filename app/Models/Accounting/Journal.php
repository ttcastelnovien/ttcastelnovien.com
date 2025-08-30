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
}
