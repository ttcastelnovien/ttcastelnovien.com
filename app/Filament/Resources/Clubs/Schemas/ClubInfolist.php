<?php

namespace App\Filament\Resources\Clubs\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ClubInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nom'),
                TextEntry::make('short_name')
                    ->label('Nom court'),
                ImageEntry::make('logo')
                    ->label('Logo')
                    ->disk('local')
                    ->visibility('private'),
                TextEntry::make('created_at')
                    ->label('Créé le')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime(),
            ]);
    }
}
