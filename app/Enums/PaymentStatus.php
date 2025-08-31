<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case WAITING = 'en_attente';
    case PAID = 'recu';
    case FIRST_PAYMENT = 'premier_paiement_recu';
    case SECOND_PAYMENT = 'deuxieme_paiement_recu';
    case THIRD_PAYMENT = 'troisieme_paiement_recu';
    case FOURTH_PAYMENT = 'quatrieme_paiement_recu';
    case FIFTH_PAYMENT = 'cinquieme_paiement_recu';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::WAITING => 'En attente',
            self::PAID => 'Payée',
            self::FIRST_PAYMENT => 'Premier paiement reçu',
            self::SECOND_PAYMENT => 'Deuxième paiement reçu',
            self::THIRD_PAYMENT => 'Troisième paiement reçu',
            self::FOURTH_PAYMENT => 'Quatrième paiement reçu',
            self::FIFTH_PAYMENT => 'Cinquième paiement reçu',
        };
    }
}
