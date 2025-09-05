<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ClothingSize: string implements HasLabel
{
    case XXXXXS = '5XS';
    case XXXXS = '4XS';
    case XXXS = '3XS';
    case XXS = '2XS';
    case XS = 'XS';
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = '2XL';
    case XXXL = '3XL';
    case XXXXL = '4XL';
    case XXXXXL = '5Xl';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::XXXXXS => '5XS / 128 / 6 ans',
            self::XXXXS => '4XS / 140 / 7 ans',
            self::XXXS => '3XS / 152 / 8 ans',
            self::XXS => '2XS / 10 ans',
            self::XS => 'XS / 12-14 ans',
            self::S => 'S / 36',
            self::M => 'M / 38-40',
            self::L => 'L / 42-44',
            self::XL => 'XL / 46-50',
            self::XXL => '2XL / 52',
            self::XXXL => '3XL / 54',
            self::XXXXL => '4XL / 56',
            self::XXXXXL => '5XL / 58',
        };
    }
}
