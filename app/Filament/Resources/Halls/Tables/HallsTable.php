<?php

namespace App\Filament\Resources\Halls\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HallsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('address_line_1')
                    ->label('Ligne d\'adresse 1')
                    ->searchable(),
                TextColumn::make('address_line_2')
                    ->label('Ligne d\'adresse 2')
                    ->searchable(),
                TextColumn::make('address_line_3')
                    ->label('Ligne d\'adresse 3')
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->label('Code postal')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('Ville')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('club.name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Créée le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Mise à jour le')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
