<?php

namespace App\Filament\Resources\JournalEntries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JournalEntriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('journal.name')
                    ->label('Journal')
                    ->searchable(),
                TextColumn::make('ledgerAccount.code')
                    ->label('Compte')
                    ->searchable(),
                TextColumn::make('clientLedgerAccount.name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('supplierLedgerAccount.name')
                    ->label('Fournisseur')
                    ->searchable(),
                TextColumn::make('credit')
                    ->label('Crédit')
                    ->money('EUR', divideBy: 100)
                    ->summarize(Sum::make())
                    ->searchable(),
                TextColumn::make('debit')
                    ->label('Débit')
                    ->money('EUR', divideBy: 100)
                    ->summarize(Sum::make())
                    ->searchable(),
                IconColumn::make('reconciled')
                    ->label('Réconcilié')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
