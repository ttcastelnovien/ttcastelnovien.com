<?php

namespace App\Filament\Resources\Licences\Pages;

use App\Filament\Resources\Licences\LicenceResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewLicence extends ViewRecord
{
    protected static string $resource = LicenceResource::class;

    public function getHeading(): string
    {
        return $this->getRecordTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('person')
                ->label('Personne')
                ->url(fn ($record) => route('filament.admin.resources.people.view', $record->person))
                ->color('info')
                ->outlined()
                ->icon(Heroicon::OutlinedEye),
            Action::make('list')
                ->label('Liste')
                ->url(LicenceResource::getUrl())
                ->button()
                ->color('gray'),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
