<?php

namespace App\Filament\Resources\People\Pages;

use App\Filament\Resources\People\PersonResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPerson extends ViewRecord
{
    protected static string $resource = PersonResource::class;

    public function getHeading(): string
    {
        return $this->getRecordTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('calendar')
                ->label('Calendrier')
                ->icon('heroicon-o-clipboard')
                ->button()
                ->color('gray')
                ->alpineClickHandler("
                    navigator.clipboard.writeText('".route('public.ical.stream', ['person' => $this->getRecord()])."')
                        .then(() => {
                            const originalText = \$el.lastChild.textContent;
                            \$el.lastChild.textContent = 'Copié !';
                            setTimeout(() => { \$el.lastChild.textContent = originalText; }, 2000);
                        })
                        .catch(() => { new FilamentNotification().title('Impossible de copier le lien').error().send(); });
                "),
            Action::make('list')
                ->label('Liste')
                ->url(PersonResource::getUrl())
                ->button()
                ->color('gray'),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
