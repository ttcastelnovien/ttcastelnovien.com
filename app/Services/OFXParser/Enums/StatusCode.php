<?php

declare(strict_types=1);

namespace App\Services\OFXParser\Enums;

use Filament\Support\Contracts\HasDescription;

enum StatusCode: string implements HasDescription
{
    case SUCCESS = '0';
    case GENERAL_ERROR = '2000';
    case MUST_CHANGE_USERPASS = '15000';
    case SIGN_ON_INVALID = '15500';
    case CUSTOMER_ACCOUNT_ALREADY_IN_USE = '15501';
    case USERPASS_LOCKOUT = '15502';

    public function getDescription(): string
    {
        return match ($this) {
            self::SUCCESS => 'Succès',
            self::GENERAL_ERROR => 'Erreur générale',
            self::MUST_CHANGE_USERPASS => 'Doit changer USERPASS',
            self::SIGN_ON_INVALID => 'Connexion invalide',
            self::CUSTOMER_ACCOUNT_ALREADY_IN_USE => 'Compte client déjà utilisé',
            self::USERPASS_LOCKOUT => 'Verrouillage USERPASS',
        };
    }
}
