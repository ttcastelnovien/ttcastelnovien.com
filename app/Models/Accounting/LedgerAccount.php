<?php

declare(strict_types=1);

namespace App\Models\Accounting;

use App\Models\Meta\Season;
use App\Models\Traits\Blamable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LedgerAccount extends Model
{
    use Blamable, HasUlids;

    protected $table = 'ledger_accounts';

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'name',
        'code',
        'parent_id',
    ];

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

    /** @return BelongsTo<LedgerAccount> */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(LedgerAccount::class, 'parent_id');
    }

    /** @return HasMany<LedgerAccount> */
    public function children(): HasMany
    {
        return $this->hasMany(LedgerAccount::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return sprintf('%s - %s', $this->code, $this->name);
    }

    /*
    |--------------------------------------------------------------------------
    | Query Builder
    |--------------------------------------------------------------------------
    */

    public static function nextAccountCode(LedgerAccount $parent): string
    {
        $parentCodeTrimmed = rtrim($parent->code, '0');

        $result = static::query()
            ->where('code', 'like', $parentCodeTrimmed.'%')
            ->max('code');

        return (string) ((int) $result + 1);
    }
}
