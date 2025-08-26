<?php

declare(strict_types=1);

namespace App\Models\Accounting;

use App\Enums\AccountingJournalType;
use App\Models\Traits\Blamable;
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
        'type',
        'debit_prefix',
        'credit_prefix',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => AccountingJournalType::class,
        ];
    }
}
