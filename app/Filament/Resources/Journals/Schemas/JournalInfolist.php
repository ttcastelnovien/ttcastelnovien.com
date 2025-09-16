<?php

namespace App\Filament\Resources\Journals\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class JournalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')->label('Nom'),
                TextEntry::make('code')->label('Code'),
                TextEntry::make('type')->label('Type'),
                TextEntry::make('start_balance')->label('Solde initial')->money('EUR', divideBy: 100),
            ]);
    }
}
