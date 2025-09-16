<?php

namespace App\Filament\Resources\Licences\Pages;

use App\Filament\Resources\Licences\LicenceResource;
use App\Models\Licence\Licence;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
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
            Action::make('list')
                ->label('Liste')
                ->url(LicenceResource::getUrl())
                ->button()
                ->icon(Heroicon::OutlinedArrowLeftCircle)
                ->color('gray'),
            Action::make('person')
                ->label('Personne')
                ->url(fn ($record) => route('filament.admin.resources.people.view', $record->person))
                ->color('gray')
                ->icon(Heroicon::OutlinedEye),
            ActionGroup::make([
                Action::make('print_licence_form')
                    ->label('Formulaire')
                    ->color('gray')
                    ->icon(Heroicon::OutlinedPrinter)
                    ->url(fn (Licence $record) => route('admin.gen.licence_form', ['licence' => $record]))
                    ->openUrlInNewTab(),
                Action::make('send_attestation')
                    ->label('Envoyer l\'attestation')
                    ->color('gray')
                    ->icon(Heroicon::OutlinedEnvelopeOpen)
                    ->url(fn (Licence $record) => route('admin.gen.licence_attestation', ['licence' => $record])),
                Action::make('generate_invoice')
                    ->label('Générer la facture')
                    ->color('gray')
                    ->icon(Heroicon::OutlinedBanknotes)
                    ->visible(fn (Licence $record) => is_null($record->invoice_id))
                    ->url(fn (Licence $record) => route('admin.gen.licence_invoice', ['licence' => $record])),
                Action::make('view_invoice')
                    ->label('Voir la facture')
                    ->color('gray')
                    ->icon(Heroicon::OutlinedDocument)
                    ->visible(fn (Licence $record) => ! is_null($record->invoice_id))
                    ->url(fn (Licence $record) => route('admin.gen.licence_invoice', ['licence' => $record])),
            ])->label('Actions')->button()->color('info'),
            EditAction::make(),
            DeleteAction::make(),
        ];
    }
}
