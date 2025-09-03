<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LicenceType: string implements HasLabel
{
    case DIRIGEANT = 'D';
    case LOISIR = 'P';
    case COMPETITION = 'T';
    case DECOUVERTE = 'I';

    public function getLabel(): ?string
    {
        return match ($this) {
            LicenceType::DIRIGEANT => 'Dirigeant',
            LicenceType::LOISIR => 'Loisir',
            LicenceType::COMPETITION => 'Compétition',
            LicenceType::DECOUVERTE => 'Découverte',
        };
    }
}
