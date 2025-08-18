<?php

namespace App\Filament\Resources\Seasons\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeasonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom'),
                TextColumn::make('starts_at')
                    ->label('Début')
                    ->date()
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->label('Fin')
                    ->date()
                    ->sortable(),
            ]);
    }
}
