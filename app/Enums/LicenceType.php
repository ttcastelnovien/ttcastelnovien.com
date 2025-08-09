<?php

declare(strict_types=1);

namespace App\Enums;

enum LicenceType: string
{
    case DIRIGEANT = 'D';
    case LOISIR = 'P';
    case COMPETITION = 'T';
    case DECOUVERTE = 'I';
    case EVENEMENTIEL = 'E';
    case LIBERTE = 'L';
}
