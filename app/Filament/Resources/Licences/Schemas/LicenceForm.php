<?php

namespace App\Filament\Resources\Licences\Schemas;

use App\Enums\LicenceDiscountType;
use App\Enums\LicenceType;
use App\Filament\Forms\Components\MoneyInput;
use App\Filament\Resources\People\Schemas\PersonForm;
use App\Models\HumanResource\Person;
use App\Models\Licence\Licence;
use App\Models\Licence\LicenceFee;
use App\Models\Meta\Season;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Illuminate\Database\Eloquent\Builder;

class LicenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('person_id')
                    ->label('Personne')
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
                    ->hiddenOn(Operation::Create)
                    ->schema([
                        Toggle::make('has_image_rights')->label('Droit à l\'image')->hidden(fn (?Licence $record) => is_null($record->image_rights)),
                        Toggle::make('has_exit_authorization')->label('Autorisation de sortie')->hidden(fn (?Licence $record) => is_null($record->exit_authorization)),
                        Toggle::make('has_care_authorization')->label('Autorisation de soins')->hidden(fn (?Licence $record) => is_null($record->care_authorization)),
                        Toggle::make('has_transport_authorization')->label('Autorisation de transport')->hidden(fn (?Licence $record) => is_null($record->transport_authorization)),
                        Toggle::make('has_medical_certificate')->label('Certificat médical')->hidden(fn (?Licence $record) => is_null($record->medical_certificate)),
                        Toggle::make('has_health_declaration')->label('Auto-questionnaire')->hidden(fn (?Licence $record) => is_null($record->health_declaration)),
                    ]),
                Select::make('licence_fee_id')
                    ->label('Tarif de base')
                    ->relationship(
                        name: 'licenceFee',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, $get) => $query
                            ->whereKeyNot($get('id'))
                            ->where('season_id', '=', Season::current()->first()->id)
                            ->orderBy('name')
                    )
                    ->getOptionLabelFromRecordUsing(fn (LicenceFee $licenceFee) => "$licenceFee->name ($licenceFee->price)")
                    ->searchable(['name'])
                    ->preload()
                    ->visibleOn('edit')
                    ->required(),
                Repeater::make('licenceDiscounts')
                    ->label('Réductions appliquées')
                    ->relationship()
                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                    ->defaultItems(0)
                    ->table([
                        Repeater\TableColumn::make('Type'),
                        Repeater\TableColumn::make('Montant'),
                        Repeater\TableColumn::make('Référence'),
                    ])
                    ->schema([
                        Select::make('type')
                            ->label('Type de réduction')
                            ->options(LicenceDiscountType::class)
                            ->preload()
                            ->required(),
                        MoneyInput::make('amount')
                            ->label('Montant de la réduction')
                            ->required(),
                        TextInput::make('reference')
                            ->label('Référence'),
                    ]),
                MarkdownEditor::make('observations')
                    ->label('Observations')
                    ->toolbarButtons([
                        ['bold', 'italic', 'strike', 'link'],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ]),
                Toggle::make('validated')
                    ->label('Validé FFTT')
                    ->hiddenOn(Operation::Create),
            ])->columns(1);
    }
}
