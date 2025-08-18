<?php

namespace App\Filament\Resources\Clubs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('short_name')
                    ->required(),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->disk('local')
                    ->visibility('private'),
            ]);
    }
}
