<?php

namespace App\Filament\Resources\TrackedMails\Pages;

use App\Filament\Resources\TrackedMails\TrackedMailResource;
use App\Models\Meta\TrackedMail;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListTrackedMails extends ListRecords
{
    protected static string $resource = TrackedMailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('delete_old')
                ->label('Supprimer à +7 jours')
                ->requiresConfirmation()
                ->action(function () {
                    TrackedMail::where('created_at', '<', now()->subWeek())->delete();
                }),
        ];
    }
}
