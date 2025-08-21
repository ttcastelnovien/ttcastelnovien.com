<?php

namespace App\Filament\Resources\TrackedMails\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrackedMailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')
                    ->label('Statut'),
                TextColumn::make('object')
                    ->label('Object'),
                TextColumn::make('recipient')
                    ->label('Destinataire'),
                TextColumn::make('message_id')
                    ->label('ID Brevo'),
                TextColumn::make('created_at')
                    ->label('Envoyé le')
                    ->isoDateTime()
                    ->sortable(),
            ]);
    }
}
