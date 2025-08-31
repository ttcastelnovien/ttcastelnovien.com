<?php

namespace App\Filament\Resources\LedgerAccounts\Pages;

use App\Filament\Resources\LedgerAccounts\LedgerAccountResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLedgerAccount extends ViewRecord
{
    protected static string $resource = LedgerAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('list')
                ->label('Retour')
                ->url(LedgerAccountResource::getUrl())
                ->button()
                ->color('gray'),
            EditAction::make(),
        ];
    }
}
