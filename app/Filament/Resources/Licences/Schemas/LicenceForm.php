<?php

namespace App\Filament\Resources\Licences\Schemas;

use App\Enums\LicenceType;
use App\Filament\Resources\People\Schemas\PersonForm;
use App\Models\HumanResource\Person;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;

class LicenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('person_id')
                    ->relationship(
                        name: 'person',
                        modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('first_name')->orderBy('last_name')
                    )
                    ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->is_minor ? "$person->full_name (mineur)" : $person->full_name)
                    ->searchable(['first_name', 'last_name'])
                    ->preload()
                    ->createOptionForm(fn (Schema $schema) => PersonForm::configure($schema))
                    ->required(),
                Select::make('licence_type')
                    ->label('Type')
                    ->options(LicenceType::class)
                    ->default('P')
                    ->required(),
                Fieldset::make('Documents obtenus')
                    ->schema([
                        Toggle::make('has_image_rights')->label('Droit à l\'image'),
                        Toggle::make('has_exit_authorization')->label('Autorisation de sortie'),
                        Toggle::make('has_care_authorization')->label('Autorisation de soins'),
                        Toggle::make('has_transport_authorization')->label('Autorisation de transport'),
                        Toggle::make('has_medical_certificate')->label('Certificat médical'),
                        Toggle::make('has_health_declaration')->label('Auto-questionnaire'),
                    ]),
                Toggle::make('validated')
                    ->label('Validé FFTT'),
            ])->columns(1);
    }
}
