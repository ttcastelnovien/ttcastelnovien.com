<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Filament\Resources\MedicalCertificates\MedicalCertificateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class MedicalCertificatesRelationManager extends RelationManager
{
    protected static string $relationship = 'medicalCertificates';

    protected static ?string $relatedResource = MedicalCertificateResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
