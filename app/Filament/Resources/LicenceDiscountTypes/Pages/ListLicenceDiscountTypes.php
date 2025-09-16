<?php

namespace App\Filament\Resources\LicenceDiscountTypes\Pages;

use App\Filament\Resources\LicenceDiscountTypes\LicenceDiscountTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLicenceDiscountTypes extends ListRecords
{
    protected static string $resource = LicenceDiscountTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
