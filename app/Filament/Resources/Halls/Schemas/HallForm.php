<?php

namespace App\Filament\Resources\Halls\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HallForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('address_line_1')
                    ->required(),
                TextInput::make('address_line_2'),
                TextInput::make('address_line_3'),
                TextInput::make('postal_code')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                Select::make('club_id')
                    ->relationship('club', 'name')
                    ->required(),
            ]);
    }
}
