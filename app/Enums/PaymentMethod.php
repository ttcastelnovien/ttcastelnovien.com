<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case HELLO_ASSO = 'hello_asso';
    case CREDIT_CARD = 'carte_bancaire';
    case PAYPAL = 'paypal';
    case BANK_TRANSFER = 'virement_bancaire';
    case CHECK = 'cheque';
    case CASH = 'especes';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::HELLO_ASSO => 'HelloAsso',
            self::CREDIT_CARD => 'Carte bancaire',
            self::PAYPAL => 'PayPal',
            self::BANK_TRANSFER => 'Virement bancaire',
            self::CHECK => 'Chèque',
            self::CASH => 'Espèces',
        };
    }
}
