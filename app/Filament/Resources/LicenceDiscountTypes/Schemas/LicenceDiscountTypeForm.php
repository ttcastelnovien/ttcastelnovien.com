<?php

namespace App\Filament\Resources\LicenceDiscountTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class LicenceDiscountTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required()
                    ->columnSpanFull(),
                Toggle::make('invoice_deductible')
                    ->label('Déductible sur facture')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
