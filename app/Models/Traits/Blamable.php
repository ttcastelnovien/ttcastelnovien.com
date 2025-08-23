<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Security\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait Blamable
{
    public static function bootBlamable(): void
    {
        static::creating(function ($model): void {
            $userId = auth()->user()?->id;

            $model->created_by_id = $userId;
            $model->updated_by_id = $userId;
        });

        static::updating(function ($model): void {
            $userId = auth()->user()?->id;

            $model->updated_by_id = $userId;
        });
    }

    /** @return BelongsTo<User> */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<User> */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
