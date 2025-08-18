<?php

namespace App\Filament\Resources\People\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('licence_number')
                    ->label('N° licence')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Prénom')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('sex')
                    ->label('Sexe')
                    ->searchable(),
                CheckboxColumn::make('is_minor')
                    ->label('Mineur')
                    ->disabled(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->formatStateUsing(fn (string $state) => preg_replace('/(\d{2})(?=\d)/', '$1 ', $state))
                    ->searchable(),
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
