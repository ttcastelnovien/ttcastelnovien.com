<?php

namespace App\Filament\Resources\Journals\Schemas;

use App\Enums\JournalType;
use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JournalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nom')->required()->unique(),
                TextInput::make('code')->label('Code')->required()->unique(),
                Select::make('type')->label('Type')->options(JournalType::class)->required(),
                MoneyInput::make('start_balance')->label('Solde initial'),
            ]);
    }
}
