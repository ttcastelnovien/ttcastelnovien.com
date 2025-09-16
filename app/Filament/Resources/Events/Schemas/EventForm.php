<?php

namespace App\Filament\Resources\Events\Schemas;

use App\Models\Communication\Group;
use App\Models\HumanResource\Person;
use App\Models\Meta\Season;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Schema;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Informations')->components([
                    TextInput::make('title')
                        ->label('Titre')
                        ->required(),
                    MarkdownEditor::make('description')
                        ->label('Description')
                        ->toolbarButtons([
                            ['bold', 'italic', 'strike', 'link'],
                            ['bulletList', 'orderedList'],
                            ['undo', 'redo'],
                        ]),
                ])->columns(1),
                Fieldset::make('Horaires')->components([
                    Toggle::make('all_day')
                        ->label('Journée entière')
                        ->default(false),
                    Flex::make([
                        DatePicker::make('start_date')
                            ->label('Date de début')
                            ->required(),
                        DatePicker::make('end_date')
                            ->label('Date de fin'),
                    ])->from('sm'),
                    Flex::make([
                        TimePicker::make('start_time')
                            ->label('Heure de début')
                            ->seconds(false),
                        TimePicker::make('end_time')
                            ->label('Heure de fin')
                            ->seconds(false),
                    ])
                        ->visibleJs(<<<'JS'
                            $get('all_day') === false
                        JS
                        )
                        ->from('sm'),
                    Flex::make([
                        TimePicker::make('check_in_time')
                            ->label('Fin du pointage')
                            ->seconds(false),
                        TimePicker::make('departure_time')
                            ->label('Départ covoiturage')
                            ->seconds(false),
                    ])->from('sm'),
                ])->columns(1),
                Fieldset::make('Lieu')->components([
                    Toggle::make('at_home')->label('À domicile'),
                    Textarea::make('address')
                        ->label('Adresse')
                        ->rows(5)
                        ->visibleJs(<<<'JS'
                            $get('at_home') === false
                        JS
                        ),
                    Flex::make([
                        TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric(),
                        TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric(),
                    ])
                        ->visibleJs(<<<'JS'
                            $get('at_home') === false
                        JS
                        )
                        ->from('sm'),
                ])->columns(1),
                Fieldset::make('Meta')->components([
                    TextInput::make('opponent')->label('Adversaire'),
                    FileUpload::make('attachments')
                        ->label('Pièces jointes')
                        ->multiple()
                        ->disk('public')
                        ->visibility('public'),
                ])->columns(1),
                Fieldset::make('Participants')->components([
                    Select::make('groups')
                        ->label('Groupes')
                        ->relationship(
                            name: 'groups',
                            modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->where('season_id', '=', Season::current()->first()->id)->orderBy('name')
                        )
                        ->multiple()
                        ->getOptionLabelFromRecordUsing(fn (Group $group) => $group->name)
                        ->searchable(['name'])
                        ->preload(),
                    Select::make('people')
                        ->label('Membres')
                        ->relationship(
                            name: 'people',
                            modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('lastname')->orderBy('firstname')
                        )
                        ->multiple()
                        ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->lastname_firstname)
                        ->searchable(['lastname_firstname'])
                        ->preload(),
                ])->columns(1),
                Select::make('season')
                    ->label('Saison')
                    ->relationship('season', 'name')
                    ->preload()
                    ->default(Season::current()->first()->id)
                    ->required(),
            ])->columns(1);
    }
}
