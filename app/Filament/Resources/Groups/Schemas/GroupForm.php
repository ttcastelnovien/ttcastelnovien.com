<?php

namespace App\Filament\Resources\Groups\Schemas;

use App\Models\HumanResource\Person;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                ColorPicker::make('color')
                    ->label('Couleur')
                    ->required(),
                Select::make('people')
                    ->label('Membres')
                    ->relationship(
                        name: 'people',
                        modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('lastname')->orderBy('firstname')
                    )
                    ->multiple()
                    ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->lastname_firstname)
                    ->searchable(['lastname_firstname'])
                    ->preload()
                    ->required(),
            ])->columns(1);
    }
}
