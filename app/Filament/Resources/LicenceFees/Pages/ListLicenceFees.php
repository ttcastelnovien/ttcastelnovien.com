<?php

namespace App\Filament\Resources\LicenceFees\Pages;

use App\Filament\Resources\LicenceFees\LicenceFeeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLicenceFees extends ListRecords
{
    protected static string $resource = LicenceFeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
