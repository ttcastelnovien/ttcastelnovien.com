<?php

namespace App\Filament\Resources\JournalEntries\Schemas;

use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;

class JournalEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Date')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('name')
                    ->label('Nom')
                    ->columnSpanFull()
                    ->required(),
                MoneyInput::make('credit')
                    ->label('Crédit')
                    ->requiredWithout('debit'),
                MoneyInput::make('debit')
                    ->label('Débit')
                    ->requiredWithout('credit'),
                Select::make('journal_id')
                    ->label('Journal')
                    ->relationship('journal', 'name')
                    ->required(),
                Select::make('ledger_account_id')
                    ->label('Compte')
                    ->relationship('ledgerAccount', 'name')
                    ->searchable(['name', 'code'])
                    ->required(),
                Select::make('client_ledger_account_id')
                    ->label('Client')
                    ->relationship('clientLedgerAccount', 'name'),
                Select::make('supplier_ledger_account_id')
                    ->label('Fournisseur')
                    ->relationship('supplierLedgerAccount', 'name'),
                Select::make('supporting_document_id')
                    ->label('Justificatif')
                    ->relationship('supportingDocument', 'id')
                    ->columnSpanFull(),
                MarkdownEditor::make('description')
                    ->label('Description')
                    ->toolbarButtons([
                        ['bold', 'italic', 'strike', 'link'],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ])
                    ->columnSpanFull(),
                Toggle::make('reconciled')
                    ->label('Réconcilié')
                    ->visibleOn(Operation::Edit)
                    ->required(),
            ]);
    }
}
