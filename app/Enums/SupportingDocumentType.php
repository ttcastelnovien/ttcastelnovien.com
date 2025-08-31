<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SupportingDocumentType: string implements HasLabel
{
    case FACTURE_CLIENT = 'facture_client';
    case AVOIR_CLIENT = 'avoir_client';
    case FACTURE_FOURNISSEUR = 'facture_fournisseur';
    case AVOIR_FOURNISSEUR = 'avoir_fournisseur';
    case RECU_DON = 'recu_don';
    case DEPOT = 'depot';
    case VIREMENT_INTERNE = 'virement_interne';

    public function getLabel(): string
    {
        return match ($this) {
            self::FACTURE_CLIENT => 'Facture client',
            self::AVOIR_CLIENT => 'Avoir client',
            self::FACTURE_FOURNISSEUR => 'Facture fournisseur',
            self::AVOIR_FOURNISSEUR => 'Avoir fournisseur',
            self::RECU_DON => 'Reçu de don',
            self::DEPOT => 'Dépôt',
            self::VIREMENT_INTERNE => 'Virement interne',
        };
    }

    public function getPrefix(): string
    {
        return match ($this) {
            self::FACTURE_CLIENT => 'FC',
            self::AVOIR_CLIENT => 'AC',
            self::FACTURE_FOURNISSEUR => 'FF',
            self::AVOIR_FOURNISSEUR => 'AF',
            self::RECU_DON => 'RD',
            self::DEPOT => 'DP',
            self::VIREMENT_INTERNE => 'VI',
        };
    }
}
