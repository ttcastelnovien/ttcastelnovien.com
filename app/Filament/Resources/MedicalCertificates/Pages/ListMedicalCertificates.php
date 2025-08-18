<?php

namespace App\Filament\Resources\MedicalCertificates\Pages;

use App\Filament\Resources\MedicalCertificates\MedicalCertificateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMedicalCertificates extends ListRecords
{
    protected static string $resource = MedicalCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
