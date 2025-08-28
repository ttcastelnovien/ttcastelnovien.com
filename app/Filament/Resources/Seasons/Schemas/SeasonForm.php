<?php

namespace App\Filament\Resources\Seasons\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SeasonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->disabledOn('edit')
                    ->required(),
                DatePicker::make('starts_at')
                    ->label('Début')
                    ->disabledOn('edit')
                    ->required(),
                TextInput::make('drive_id')
                    ->label('ID du dossier Google Drive')
                    ->required(),
                DatePicker::make('ends_at')
                    ->label('Fin')
                    ->disabledOn('edit')
                    ->required(),
            ]);
    }
}
