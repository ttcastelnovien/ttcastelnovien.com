<?php

namespace App\Filament\Resources\AnalyticAccounts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AnalyticAccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('balance')
                    ->money('EUR', divideBy: 100),
                TextEntry::make('created_at')
                    ->label('Créé le')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->label('Mis à jour le')
                    ->dateTime(),
            ])->columns(3);
    }
}
