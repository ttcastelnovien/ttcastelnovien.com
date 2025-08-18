<?php

namespace App\Filament\Resources\MedicalCertificates\Schemas;

use App\Models\HumanResource\Person;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                        modifyQueryUsing: fn ($query, $get) => $query->where('id', '!=', $get('id'))->orderBy('first_name')->orderBy('last_name')
                    )
                    ->getOptionLabelFromRecordUsing(fn (Person $person) => $person->full_name)
                    ->searchable(['first_name', 'last_name'])
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
                FileUpload::make('file')
                    ->disk('certificates')
                    ->visibility('private')
                    ->label('Fichier')
                    ->acceptedFileTypes(['application/pdf']),
            ]);
    }
}
