<?php

declare(strict_types=1);

namespace App\Enums;

enum MailObject: string
{
    case INVITATION = 'invitation';
    case FORGOT_PASSWORD = 'forgot_password';
    case ATTESTATION_LICENCE = 'attestation_licence';

    public function getTemplateId(): int
    {
        return match ($this) {
            self::INVITATION => 1,
            self::FORGOT_PASSWORD => 2,
            self::ATTESTATION_LICENCE => 3,
        };
    }
}
