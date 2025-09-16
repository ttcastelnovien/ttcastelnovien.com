<?php

namespace App\Filament\Resources\AnalyticAccounts\Pages;

use App\Filament\Resources\AnalyticAccounts\AnalyticAccountResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAnalyticAccount extends ViewRecord
{
    protected static string $resource = AnalyticAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
