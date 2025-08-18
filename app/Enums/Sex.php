<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Sex: string implements HasLabel
{
    case Homme = 'H';
    case Femme = 'F';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Homme => 'Homme',
            self::Femme => 'Femme',
        };
    }
}
