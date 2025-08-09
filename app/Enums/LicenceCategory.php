<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

enum LicenceCategory: string
{
    case POUSSIN = 'P';
    case BENJAMIN_1 = 'B1';
    case BENJAMIN_2 = 'B2';
    case MINIME_1 = 'M1';
    case MINIME_2 = 'M2';
    case CADET_1 = 'C1';
    case CADET_2 = 'C2';
    case JUNIOR_1 = 'J1';
    case JUNIOR_2 = 'J2';
    case JUNIOR_3 = 'J3';
    case JUNIOR_4 = 'J4';
    case SENIOR = 'S';
    case VETERAN_40 = 'V40';
    case VETERAN_45 = 'V45';
    case VETERAN_50 = 'V50';
    case VETERAN_55 = 'V55';
    case VETERAN_60 = 'V60';
    case VETERAN_65 = 'V65';
    case VETERAN_70 = 'V70';
    case VETERAN_75 = 'V75';
    case VETERAN_80 = 'V80';
    case VETERAN_85 = 'V85';
    case VETERAN_90 = 'V90';

    public function fromBirthDate(Carbon $birthDate): self
    {
        $currentYear = now()->year;
        $birthYear = $birthDate->year;

        if ($birthYear <= $currentYear - 8) {
            return LicenceCategory::POUSSIN;
        }

        if ($birthYear === $currentYear - 9) {
            return LicenceCategory::BENJAMIN_1;
        }

        if ($birthYear === $currentYear - 10) {
            return LicenceCategory::BENJAMIN_2;
        }

        if ($birthYear === $currentYear - 11) {
            return LicenceCategory::MINIME_1;
        }

        if ($birthYear === $currentYear - 12) {
            return LicenceCategory::MINIME_2;
        }

        if ($birthYear === $currentYear - 13) {
            return LicenceCategory::CADET_1;
        }

        if ($birthYear === $currentYear - 14) {
            return LicenceCategory::CADET_2;
        }

        if ($birthYear === $currentYear - 15) {
            return LicenceCategory::JUNIOR_1;
        }

        if ($birthYear === $currentYear - 16) {
            return LicenceCategory::JUNIOR_2;
        }

        if ($birthYear === $currentYear - 17) {
            return LicenceCategory::JUNIOR_3;
        }

        if ($birthYear === $currentYear - 18) {
            return LicenceCategory::JUNIOR_4;
        }

        if ($birthYear >= $currentYear - 89) {
            return LicenceCategory::VETERAN_90;
        }

        if ($birthYear >= $currentYear - 84) {
            return LicenceCategory::VETERAN_85;
        }

        if ($birthYear >= $currentYear - 79) {
            return LicenceCategory::VETERAN_80;
        }

        if ($birthYear >= $currentYear - 74) {
            return LicenceCategory::VETERAN_75;
        }

        if ($birthYear >= $currentYear - 69) {
            return LicenceCategory::VETERAN_70;
        }

        if ($birthYear >= $currentYear - 64) {
            return LicenceCategory::VETERAN_65;
        }

        if ($birthYear >= $currentYear - 59) {
            return LicenceCategory::VETERAN_60;
        }

        if ($birthYear >= $currentYear - 54) {
            return LicenceCategory::VETERAN_55;
        }

        if ($birthYear >= $currentYear - 49) {
            return LicenceCategory::VETERAN_50;
        }

        if ($birthYear >= $currentYear - 44) {
            return LicenceCategory::VETERAN_45;
        }

        if ($birthYear >= $currentYear - 39) {
            return LicenceCategory::VETERAN_40;
        }

        return LicenceCategory::SENIOR;
    }
}
