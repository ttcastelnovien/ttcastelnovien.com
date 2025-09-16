<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum JournalType: string implements HasLabel
{
    case VENTES = 'ventes';
    case ACHATS = 'achats';
    case ESPECES = 'especes';
    case BANQUE = 'banque';
    case CARTE_BANCAIRE = 'carte_bancaire';
    case DIVERS = 'divers';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::VENTES => 'Ventes',
            self::ACHATS => 'Achats',
            self::ESPECES => 'Espèces',
            self::BANQUE => 'Banque',
            self::CARTE_BANCAIRE => 'Carte bancaire',
            self::DIVERS => 'Divers',
        };
    }

    public function prefix(): string
    {
        return match ($this) {
            self::VENTES => 'VEN',
            self::ACHATS => 'ACH',
            self::ESPECES => 'ESP',
            self::BANQUE => 'BNK',
            self::CARTE_BANCAIRE => 'CB',
            self::DIVERS => 'DIV',
        };
    }
}
