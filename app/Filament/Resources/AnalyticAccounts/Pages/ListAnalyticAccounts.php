<?php

namespace App\Filament\Resources\AnalyticAccounts\Pages;

use App\Filament\Resources\AnalyticAccounts\AnalyticAccountResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnalyticAccounts extends ListRecords
{
    protected static string $resource = AnalyticAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
