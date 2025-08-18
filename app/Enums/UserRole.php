<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case ADMIN = 'admin';
    case USER = 'user';
    case HISTORY = 'history';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::USER => 'Utilisateur',
            self::HISTORY => 'Historien',
        };
    }
}
