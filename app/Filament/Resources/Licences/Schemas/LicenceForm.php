<?php

namespace App\Filament\Resources\Licences\Schemas;

use App\Enums\LicenceType;
use App\Filament\Resources\LicenceDiscounts\Schemas\LicenceDiscountForm;
use App\Filament\Resources\People\Schemas\PersonForm;
use App\Models\HumanResource\Person;
use App\Models\Licence\Licence;
use App\Models\Licence\LicenceFee;
use App\Models\Meta\Season;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
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
                        modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('lastname')->orderBy('firstname')
                    )
                    ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->is_minor ? "$person->lastname_firstname (mineur)" : $person->lastname_firstname)
                    ->searchable(['lastname_firstname'])
                    ->preload()
                    ->createOptionForm(fn (Schema $schema) => PersonForm::configure($schema))
                    ->required(),
                Select::make('type')
                    ->label('Type')
                    ->options(LicenceType::class)
                    ->default('P')
                    ->required(),
                Fieldset::make('Documents obtenus')
                    ->hiddenOn(Operation::Create)
                    ->schema([
                        Select::make('has_image_rights')
                            ->label('Droit à l\'image')
                            ->nullable()
                            ->options([true => 'Accepté', false => 'Refusé'])
                            ->visible(fn (?Licence $record) => $record->needs_image_rights),
                        Select::make('has_exit_authorization')
                            ->label('Autorisation de sortie')
                            ->nullable()
                            ->options([true => 'Accepté', false => 'Refusé'])
                            ->visible(fn (?Licence $record) => $record->needs_exit_authorization),
                        Select::make('has_care_authorization')
                            ->label('Autorisation de soins')
                            ->nullable()
                            ->options([true => 'Accepté', false => 'Refusé'])
                            ->visible(fn (?Licence $record) => $record->needs_care_authorization),
                        Select::make('has_transport_authorization')
                            ->label('Autorisation de transport')
                            ->nullable()
                            ->options([true => 'Accepté', false => 'Refusé'])
                            ->visible(fn (?Licence $record) => $record->needs_transport_authorization),
                        Select::make('has_medical_certificate')
                            ->label('Certificat médical')
                            ->nullable()
                            ->options([true => 'Accepté', false => 'Refusé'])
                            ->visible(fn (?Licence $record) => $record->needs_medical_certificate),
                        Select::make('has_health_declaration')
                            ->label('Auto-questionnaire')
                            ->nullable()
                            ->options([true => 'Accepté', false => 'Refusé'])
                            ->visible(fn (?Licence $record) => $record->needs_health_declaration),
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
                    ->schema(fn (Schema $schema) => LicenceDiscountForm::configure($schema)->getComponents()),
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

    public static function configureFromRelationManager(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('type')
                    ->label('Type')
                    ->options(LicenceType::class)
                    ->default('P')
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
                    ->schema(fn (Schema $schema) => LicenceDiscountForm::configure($schema)->getComponents()),
                MarkdownEditor::make('observations')
                    ->label('Observations')
                    ->toolbarButtons([
                        ['bold', 'italic', 'strike', 'link'],
                        ['bulletList', 'orderedList'],
                        ['undo', 'redo'],
                    ]),
            ])->columns(1);
    }
}
