<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MailStatus: string implements HasLabel
{
    case Pending = 'pending';

    case Sent = 'request';
    case Deferred = 'deferred';
    case Delivered = 'delivered';

    case UniqueOpened = 'unique_opened';
    case Opened = 'opened';
    case Clicked = 'click';

    case SoftBounced = 'soft_bounce';
    case HardBounced = 'hard_bounce';
    case Spam = 'spam';

    case Failed = 'failed';
    case InvalidEmail = 'invalid_email';
    case Blocked = 'blocked';
    case Error = 'error';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'en attente',
            self::Sent => 'envoyé',
            self::Deferred => 'reporté',
            self::Delivered => 'délivré',
            self::Opened => 'réouvert',
            self::UniqueOpened => 'ouvert',
            self::Clicked => 'cliqué',
            self::SoftBounced => 'soft bounce',
            self::HardBounced => 'hard bounce',
            self::Spam => 'spam',
            self::Failed => 'échoué',
            self::InvalidEmail => 'email invalide',
            self::Blocked => 'bloqué',
            self::Error => 'erreur',
        };
    }
}
