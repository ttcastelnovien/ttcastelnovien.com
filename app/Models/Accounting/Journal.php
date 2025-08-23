<?php

declare(strict_types=1);

namespace App\Models\Accounting;

use App\Enums\AccountingJournalType;
use App\Models\Licence\Licence;
use App\Models\Meta\Season;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Journal extends Model
{
    use HasUlids;

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
        'prefix_in',
        'prefix_out',
        'season_id',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'type' => AccountingJournalType::class,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /** @return BelongsTo<Season> */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /** @return HasMany<Licence> */
    public function licences(): HasMany
    {
        return $this->hasMany(Licence::class);
    }
}
