<?php

namespace App\Filament\Resources\MedicalCertificates\Pages;

use App\Filament\Resources\MedicalCertificates\MedicalCertificateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMedicalCertificate extends EditRecord
{
    protected static string $resource = MedicalCertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
