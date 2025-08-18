<?php

declare(strict_types=1);

namespace App\Enums;

use App\Models\Meta\Season;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Support\Carbon;

enum LicenceCategory: string implements HasLabel
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

    public static function fromBirthDate(Carbon $birthDate, Season $season): self
    {
        $currentYear = $season->starts_at->year;
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

    public function getLabel(): ?string
    {
        return match ($this) {
            LicenceCategory::POUSSIN => 'Poussin',
            LicenceCategory::BENJAMIN_1 => 'Benjamin 1',
            LicenceCategory::BENJAMIN_2 => 'Benjamin 2',
            LicenceCategory::MINIME_1 => 'Minime 1',
            LicenceCategory::MINIME_2 => 'Minime 2',
            LicenceCategory::CADET_1 => 'Cadet 1',
            LicenceCategory::CADET_2 => 'Cadet 2',
            LicenceCategory::JUNIOR_1 => 'Junior 1',
            LicenceCategory::JUNIOR_2 => 'Junior 2',
            LicenceCategory::JUNIOR_3 => 'Junior 3',
            LicenceCategory::JUNIOR_4 => 'Junior 4',
            LicenceCategory::SENIOR => 'Senior',
            LicenceCategory::VETERAN_40 => 'Vétéran 40',
            LicenceCategory::VETERAN_45 => 'Vétéran 45',
            LicenceCategory::VETERAN_50 => 'Vétéran 50',
            LicenceCategory::VETERAN_55 => 'Vétéran 55',
            LicenceCategory::VETERAN_60 => 'Vétéran 60',
            LicenceCategory::VETERAN_65 => 'Vétéran 65',
            LicenceCategory::VETERAN_70 => 'Vétéran 70',
            LicenceCategory::VETERAN_75 => 'Vétéran 75',
            LicenceCategory::VETERAN_80 => 'Vétéran 80',
            LicenceCategory::VETERAN_85 => 'Vétéran 85',
            LicenceCategory::VETERAN_90 => 'Vétéran 90',
        };
    }

    public static function isMinorCategory(self $category): bool
    {
        return in_array($category, [
            LicenceCategory::POUSSIN,
            LicenceCategory::BENJAMIN_1,
            LicenceCategory::BENJAMIN_2,
            LicenceCategory::MINIME_1,
            LicenceCategory::MINIME_2,
            LicenceCategory::CADET_1,
            LicenceCategory::CADET_2,
            LicenceCategory::JUNIOR_1,
            LicenceCategory::JUNIOR_2,
            LicenceCategory::JUNIOR_3,
            LicenceCategory::JUNIOR_4,
        ], true);
    }

    public static function isInferiorCategory(self $reference, self $target, bool $inclusive): bool
    {
        $weightedCategories = self::getWeightedCategories();

        if ($inclusive) {
            return $weightedCategories[$reference->value] <= $weightedCategories[$target->value];
        }

        return $weightedCategories[$reference->value] < $weightedCategories[$target->value];
    }

    public static function isSuperiorCategory(self $reference, self $target, bool $inclusive): bool
    {
        $weightedCategories = self::getWeightedCategories();

        if ($inclusive) {
            return $weightedCategories[$reference->value] >= $weightedCategories[$target->value];
        }

        return $weightedCategories[$reference->value] > $weightedCategories[$target->value];
    }

    /** @return array<string, int> */
    private static function getWeightedCategories(): array
    {
        return [
            LicenceCategory::POUSSIN->value => 1,
            LicenceCategory::BENJAMIN_1->value => 2,
            LicenceCategory::BENJAMIN_2->value => 3,
            LicenceCategory::MINIME_1->value => 4,
            LicenceCategory::MINIME_2->value => 5,
            LicenceCategory::CADET_1->value => 6,
            LicenceCategory::CADET_2->value => 7,
            LicenceCategory::JUNIOR_1->value => 8,
            LicenceCategory::JUNIOR_2->value => 9,
            LicenceCategory::JUNIOR_3->value => 10,
            LicenceCategory::JUNIOR_4->value => 11,
            LicenceCategory::SENIOR->value => 12,
            LicenceCategory::VETERAN_40->value => 13,
            LicenceCategory::VETERAN_45->value => 14,
            LicenceCategory::VETERAN_50->value => 15,
            LicenceCategory::VETERAN_55->value => 16,
            LicenceCategory::VETERAN_60->value => 17,
            LicenceCategory::VETERAN_65->value => 18,
            LicenceCategory::VETERAN_70->value => 19,
            LicenceCategory::VETERAN_75->value => 20,
            LicenceCategory::VETERAN_80->value => 21,
            LicenceCategory::VETERAN_85->value => 22,
            LicenceCategory::VETERAN_90->value => 23,
        ];
    }
}
