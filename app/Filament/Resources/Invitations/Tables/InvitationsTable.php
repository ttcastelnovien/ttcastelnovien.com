<?php

namespace App\Filament\Resources\Invitations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvitationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('person.full_name')
                    ->label('Personne'),
                TextColumn::make('roles')
                    ->label('Rôles'),
                TextColumn::make('created_at')
                    ->label('Invité(e) le')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('expires_at')
                    ->label('Expire le')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
