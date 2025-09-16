<?php

namespace App\Filament\Resources\AnalyticAccountEntries\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AnalyticAccountEntriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('analyticAccount.name')
                    ->label('Compte analytique')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('entry.name')
                    ->label('Écriture')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->money('EUR', divideBy: 100)
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
