<?php

namespace App\Filament\Resources\AnalyticAccountEntries\Pages;

use App\Filament\Resources\AnalyticAccountEntries\AnalyticAccountEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnalyticAccountEntries extends ListRecords
{
    protected static string $resource = AnalyticAccountEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
