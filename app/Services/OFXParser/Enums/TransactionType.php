<?php

declare(strict_types=1);

namespace App\Services\OFXParser\Enums;

use Filament\Support\Contracts\HasDescription;

enum TransactionType: string implements HasDescription
{
    case CREDIT = 'CREDIT';
    case DEBIT = 'DEBIT';
    case INTEREST = 'INT';
    case DIVIDEND = 'DIV';
    case FEE = 'FEE';
    case SERVICE_CHARGE = 'SRVCHG';
    case DEPOSIT = 'DEP';
    case ATM = 'ATM';
    case POINT_OF_SALE = 'POS';
    case TRANSFER = 'XFER';
    case CHECK = 'CHECK';
    case PAYMENT = 'PAYMENT';
    case CASH = 'CASH';
    case DIRECT_DEPOSIT = 'DIRECTDEP';
    case DIRECT_DEBIT = 'DIRECTDEBIT';
    case REPEAT_PAYMENT = 'REPEATPMT';
    case OTHER = 'OTHER';

    public function getDescription(): string
    {
        return match ($this) {
            self::CREDIT => 'Crédit générique',
            self::DEBIT => 'Débit générique',
            self::INTEREST => 'Intérêts perçus ou versés',
            self::DIVIDEND => 'Dividende',
            self::FEE => 'Frais bancaires',
            self::SERVICE_CHARGE => 'Frais de service',
            self::DEPOSIT => 'Dépôt',
            self::ATM => 'Opération au distributeur (débit ou crédit)',
            self::POINT_OF_SALE => 'Opération au point de vente (débit ou crédit)',
            self::TRANSFER => 'Virement',
            self::CHECK => 'Chèque',
            self::PAYMENT => 'Paiement électronique',
            self::CASH => 'Retrait en espèces',
            self::DIRECT_DEPOSIT => 'Dépôt direct',
            self::DIRECT_DEBIT => 'Prélèvement automatique (initié par le marchand)',
            self::REPEAT_PAYMENT => 'Paiement récurrent / ordre permanent',
            self::OTHER => 'Autre',
        };
    }
}
