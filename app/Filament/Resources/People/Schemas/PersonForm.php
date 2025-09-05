<?php

namespace App\Filament\Resources\People\Schemas;

use App\Enums\Sex;
use App\Models\HumanResource\Person;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Identité')->components([
                    TextInput::make('firstname')
                        ->label('Prénom')
                        ->required(),
                    TextInput::make('lastname')
                        ->label('Nom')
                        ->required(),
                    Select::make('sex')
                        ->label('Sexe')
                        ->options(Sex::class)
                        ->default('H')
                        ->required(),
                    TextInput::make('birth_name')
                        ->label('Nom de naissance'),
                    DatePicker::make('birth_date')
                        ->label('Date de naissance')
                        ->required(),
                    TextInput::make('birth_city')
                        ->label('Lieu de naissance (CP + ville)'),
                ]),
                Fieldset::make('Coordonnées')->components([
                    TextInput::make('email')
                        ->label('Adresse e-mail')
                        ->email(),
                    TextInput::make('phone')
                        ->label('Téléphone')
                        ->tel(),
                    TextInput::make('address_line_1')
                        ->label('Ligne d\'adresse 1')
                        ->required(),
                    TextInput::make('address_line_2')
                        ->label('Ligne d\'adresse 2'),
                    TextInput::make('address_line_3')
                        ->label('Ligne d\'adresse 3'),
                    TextInput::make('postal_code')
                        ->label('Code postal')
                        ->required(),
                    TextInput::make('city')
                        ->label('Ville')
                        ->required(),
                ]),
                Fieldset::make('Administratif')->components([
                    TextInput::make('licence_number')
                        ->label('Numéro de licence'),
                    DatePicker::make('last_image_rights_authorization_date')
                        ->label('Date du dernier droit à l\'image')
                        ->date(),
                    TextInput::make('nationality')
                        ->label('Nationalité')
                        ->required()
                        ->default('FR'),
                    TextInput::make('father_name')
                        ->label('Nom du père si pas FR'),
                    TextInput::make('mother_name')
                        ->label('Nom de la mère si pas FR'),
                    TextInput::make('clothing_size')
                        ->label('Taille de vêtement'),
                    TextInput::make('pants_size')
                        ->label('Taille de pantalon'),
                ]),
                Fieldset::make('Famille')->components([
                    Select::make('parents')
                        ->label('Parents')
                        ->multiple()
                        ->relationship(
                            name: 'parents',
                            modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('lastname')->orderBy('firstname')
                        )
                        ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->lastname_firstname)
                        ->searchable(['lastname_firstname'])
                        ->preload()
                        ->createOptionForm(fn (Schema $schema) => self::configure($schema)),
                    Select::make('children')
                        ->label('Enfants')
                        ->multiple()
                        ->relationship(
                            name: 'children',
                            modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('lastname')->orderBy('firstname')
                        )
                        ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->lastname_firstname)
                        ->searchable(['lastname_firstname'])
                        ->preload()
                        ->createOptionForm(fn (Schema $schema) => self::configure($schema)),
                ]),
            ])->columns(1);
    }
}
