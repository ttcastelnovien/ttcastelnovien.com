<?php

namespace App\Filament\Resources\Groups\Pages;

use App\Filament\Resources\Groups\GroupResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGroup extends ViewRecord
{
    protected static string $resource = GroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('list')
                ->label('Retour')
                ->url(GroupResource::getUrl())
                ->button()
                ->color('gray'),
            EditAction::make(),
        ];
    }
}
