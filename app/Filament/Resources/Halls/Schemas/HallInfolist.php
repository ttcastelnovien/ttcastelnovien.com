<?php

namespace App\Filament\Resources\Halls\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class HallInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id')
                    ->label('ID'),
                TextEntry::make('name'),
                TextEntry::make('address_line_1'),
                TextEntry::make('address_line_2'),
                TextEntry::make('address_line_3'),
                TextEntry::make('postal_code'),
                TextEntry::make('city'),
                TextEntry::make('latitude')
                    ->numeric(),
                TextEntry::make('longitude')
                    ->numeric(),
                TextEntry::make('club.name'),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
