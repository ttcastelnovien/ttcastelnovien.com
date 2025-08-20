<?php

declare(strict_types=1);

namespace App\Services\PDFGenerator;

enum PDFTemplate: string
{
    case FACTURE = 'facture';
    case AVOIR = 'avoir';
    case ATTESTATION_LICENCE = 'attestation_licence';

    case NOTE_FRAIS = 'note_frais';
    case RECU_DON = 'recu_don';

    case COMPTE_RESULTAT_CERFA = 'compte_resultat_cerfa';
    case COMPTE_RESULTAT_2020 = 'compte_resultat_2020';
    case BUDGET_PREVISIONNEL = 'budget_previsionnel';
    case BILAN_FINANCIER = 'bilan_financier';
    case JOURNAL = 'journal';

    /**
     * @return array{string, string, string, string} [top, bottom, left, right]
     */
    public function getMargins(): array
    {
        return match ($this) {
            self::FACTURE, self::AVOIR => ['40mm', '50mm', '5mm', '5mm'],
            default => ['5mm', '5mm', '5mm', '5mm'],
        };
    }
}
