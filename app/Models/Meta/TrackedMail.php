<?php

namespace App\Models\Meta;

use App\Enums\MailObject;
use App\Enums\MailStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class TrackedMail extends Model
{
    protected $table = 'tracked_mails';

    /*
    |--------------------------------------------------------------------------
    | Traits modifiers
    |--------------------------------------------------------------------------
    */

    use HasUlids;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */

    /** @var list<string> */
    protected $fillable = [
        'status',
        'object',
        'message_id',
        'recipient',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'status' => MailStatus::class,
            'object' => MailObject::class,
        ];
    }
}
