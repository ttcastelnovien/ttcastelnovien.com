<?php

namespace App\Filament\Resources\JournalEntries\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JournalEntryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('date')->label('Date')->date()->inlineLabel(),
                TextEntry::make('name')->label('Référence')->inlineLabel(),
                TextEntry::make('description')->label('Description')->markdown()->inlineLabel(),
                TextEntry::make('journal.name')->label('Journal')->inlineLabel(),
                TextEntry::make('ledgerAccount.name')->label('Compte')->inlineLabel(),
                TextEntry::make('clientLedgerAccount.name')->label('Client')->inlineLabel(),
                TextEntry::make('supplierLedgerAccount.name')->label('Fournisseur')->inlineLabel(),
                TextEntry::make('supportingDocument.id')->label('Justificatif')->inlineLabel(),
                TextEntry::make('credit')->label('Crédit')->money('EUR', divideBy: 100)->inlineLabel(),
                TextEntry::make('debit')->label('Débit')->money('EUR', divideBy: 100)->inlineLabel(),
                IconEntry::make('reconciled')->label('Réconcilié')->boolean()->inlineLabel(),
                TextEntry::make('created_at')->label('Créé le')->dateTime()->inlineLabel(),
                TextEntry::make('updated_at')->label('Modifié le')->dateTime()->inlineLabel(),
                TextEntry::make('createdBy.lastname_firstname')->label('Créé par')->inlineLabel(),
                TextEntry::make('updatedBy.lastname_firstname')->label('Modifié par')->inlineLabel(),
            ]);
    }
}
