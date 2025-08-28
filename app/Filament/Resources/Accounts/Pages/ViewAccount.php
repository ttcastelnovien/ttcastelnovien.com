<?php

namespace App\Filament\Resources\Accounts\Pages;

use App\Filament\Resources\Accounts\AccountResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAccount extends ViewRecord
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('list')
                ->label('Retour')
                ->url(AccountResource::getUrl())
                ->button()
                ->color('gray'),
            EditAction::make(),
        ];
    }
}
