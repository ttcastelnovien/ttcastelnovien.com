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

    case FORMULAIRE_LICENCE = 'formulaire_licence';

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
            self::FORMULAIRE_LICENCE => ['35mm', '12mm', '5mm', '5mm'],
            self::ATTESTATION_LICENCE => ['70mm', '12mm', '5mm', '5mm'],
            default => ['5mm', '5mm', '5mm', '5mm'],
        };
    }

    /** @return list<string> */
    public function getDestination(): array
    {
        return match ($this) {
            self::FACTURE => ['COMPTABILITÉ', 'À TRAITER', 'FACTURES', 'CLIENTS'],
            self::AVOIR => ['COMPTABILITÉ', 'À TRAITER', 'AVOIRS', 'CLIENTS'],
            self::FORMULAIRE_LICENCE, self::ATTESTATION_LICENCE => ['LICENCIÉS', '{full_name}', 'ADHÉSION'],
            self::NOTE_FRAIS => ['COMPTABILITÉ', 'À TRAITER', 'NOTES DE FRAIS'],
            self::RECU_DON => ['COMPTABILITÉ', 'À TRAITER', 'REÇUS DE DON'],
            self::COMPTE_RESULTAT_CERFA => ['COMPTABILITÉ', 'EXPORTS', 'COMPTES DE RÉSULTAT', 'CERFA'],
            self::COMPTE_RESULTAT_2020 => ['COMPTABILITÉ', 'EXPORTS', 'COMPTES DE RÉSULTAT', 'RÉFORME 2020'],
            self::BILAN_FINANCIER => ['COMPTABILITÉ', 'EXPORTS', 'BILANS FINANCIERS'],
            self::JOURNAL => ['COMPTABILITÉ', 'EXPORTS', 'JOURNAUX'],
            self::BUDGET_PREVISIONNEL => ['COMPTABILITÉ', 'EXPORTS', 'BUDGETS PRÉVISIONNELS'],
        };
    }
}
