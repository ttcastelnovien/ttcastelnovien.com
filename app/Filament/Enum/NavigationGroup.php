<?php

declare(strict_types=1);

namespace App\Filament\Enum;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroup implements HasLabel
{
    case GESTION_HUMAINE;
    case COMMUNICATION;
    case COMPTABILITE;
    case SPORTIF;
    case DOCUMENTAIRE;
    case META;

    public function getLabel(): string
    {
        return match ($this) {
            self::GESTION_HUMAINE => 'Gestion humaine',
            self::COMMUNICATION => 'Communication',
            self::COMPTABILITE => 'Comptabilité',
            self::SPORTIF => 'Sportif',
            self::DOCUMENTAIRE => 'Documentaire',
            self::META => 'Meta',
        };
    }
}
