<?php

namespace App\Filament\Resources\AnalyticAccountEntries\Schemas;

use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AnalyticAccountEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('analytic_account_id')
                    ->relationship('analyticAccount', 'name')
                    ->preload()
                    ->required(),
                Select::make('journal_entry_id')
                    ->relationship('entry', 'name')
                    ->preload()
                    ->required(),
                MoneyInput::make('amount')
                    ->label('Montant')
                    ->required(),
            ]);
    }
}
