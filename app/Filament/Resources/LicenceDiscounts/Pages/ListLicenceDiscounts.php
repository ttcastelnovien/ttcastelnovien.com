<?php

namespace App\Filament\Resources\LicenceDiscounts\Pages;

use App\Filament\Resources\LicenceDiscounts\LicenceDiscountResource;
use Filament\Resources\Pages\ListRecords;

class ListLicenceDiscounts extends ListRecords
{
    protected static string $resource = LicenceDiscountResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
