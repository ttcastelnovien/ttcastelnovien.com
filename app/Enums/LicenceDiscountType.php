<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum LicenceDiscountType: string implements HasLabel
{
    case PASS_SPORT = 'pass_sport';
    case SUPER_U = 'super_u';
    case ANCV = 'ancv';
    case FAMILLE = 'famille';
    case CUSTOM = 'custom';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PASS_SPORT => 'Pass Sport',
            self::SUPER_U => 'Super U',
            self::ANCV => 'Chèque vacances ANCV',
            self::FAMILLE => 'Famille',
            self::CUSTOM => 'Personnalisé',
        };
    }
}
