<?php

namespace App\Filament\Resources\MedicalCertificates\Schemas;

use App\Filament\Forms\Components\DriveFileUpload;
use App\Models\HumanResource\Person;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class MedicalCertificateForm
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
                    ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->lastname_firstname)
                    ->searchable(['lastname_firstname'])
                    ->preload()
                    ->required(),
                TextInput::make('doctor_name')
                    ->label('Nom du docteur')
                    ->required(),
                TextInput::make('doctor_identifier')
                    ->label('Identifiant RPPS du docteur')
                    ->required(),
                DatePicker::make('date')
                    ->label('Date du certificat')
                    ->required(),
                DriveFileUpload::make('file')
                    ->label('Fichier')
                    ->visibleOn('create')
                    ->setFileName(fn () => 'certificat_medical')
                    ->setDrivePath(function (Get $get) {
                        return [
                            'LICENCIÉS',
                            Person::find($get('person_id'))->lastname_firstname,
                            'ADHÉSION',
                        ];
                    })
                    ->acceptedFileTypes(['application/pdf']),
            ]);
    }
}
