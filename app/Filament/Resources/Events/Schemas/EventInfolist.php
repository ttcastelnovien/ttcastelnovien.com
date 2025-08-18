<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations')
                    ->components([
                        TextEntry::make('title')
                            ->label('Titre'),
                        TextEntry::make('description')
                            ->markdown()
                            ->label('Description'),
                        TextEntry::make('date')
                            ->label('Date'),
                    ]),
                Section::make('Lieu')
                    ->components([
                        IconEntry::make('at_home')
                            ->boolean(),
                        TextEntry::make('address')
                            ->label('Adresse'),
                        TextEntry::make('latitude')
                            ->label('Latitude')
                            ->numeric(),
                        TextEntry::make('longitude')
                            ->label('Longitude')
                            ->numeric(),
                    ]),
                Section::make('Meta')
                    ->components([
                        TextEntry::make('check_in_time')
                            ->label('Fin du pointage')
                            ->time(),
                        TextEntry::make('departure_time')
                            ->label('Départ covoiturage')
                            ->time(),
                        TextEntry::make('opponent')
                            ->label('Adversaire'),
                    ]),
                Section::make('Historique')
                    ->components([
                        TextEntry::make('created_at')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->dateTime(),
                    ]),
            ]);
    }
}
