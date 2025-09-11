<?php

namespace App\Filament\Resources\LicenceDiscounts\Schemas;

use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LicenceDiscountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('licence_discount_type_id')
                    ->label('Type de réduction')
                    ->relationship(name: 'type', titleAttribute: 'name')
                    ->preload()
                    ->required(),
                MoneyInput::make('amount')
                    ->label('Montant de la réduction')
                    ->required(),
                TextInput::make('reference')
                    ->label('Référence'),
            ]);
    }
}
