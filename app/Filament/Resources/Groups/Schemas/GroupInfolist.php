<?php

namespace App\Filament\Resources\Groups\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nom')
                    ->inlineLabel(),
                ColorEntry::make('color')
                    ->label('Couleur')
                    ->inlineLabel(),
                TextEntry::make('season.short_name')
                    ->label('Saison')
                    ->inlineLabel(),
            ])->columns(1);
    }
}
