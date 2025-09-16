<?php

namespace App\Filament\Resources\AnalyticAccounts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnalyticAccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
            ]);
    }
}
