<?php

namespace App\Filament\Resources\LicenceFees\Schemas;

use App\Enums\LicenceCategory;
use App\Enums\LicenceType;
use App\Filament\Forms\Components\MoneyInput;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LicenceFeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->columnSpanFull()
                    ->required(),
                MoneyInput::make('price')
                    ->label('Prix')
                    ->columnSpanFull()
                    ->required(),
                Select::make('licence_types')
                    ->label('Types de licence')
                    ->options(LicenceType::class)
                    ->multiple()
                    ->columnSpanFull()
                    ->required(),
                CheckboxList::make('licence_categories')
                    ->label('Catégories d\'âge')
                    ->options(LicenceCategory::class)
                    ->columnSpanFull()
                    ->columns([
                        'sm' => 2,
                        'md' => 3,
                    ])
                    ->bulkToggleable()
                    ->required(),
            ])->columns();
    }
}
