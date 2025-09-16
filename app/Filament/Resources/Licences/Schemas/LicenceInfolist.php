<?php

namespace App\Filament\Resources\Licences\Schemas;

use App\Enums\LicenceDocumentStatus;
use App\Models\Licence\Licence;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;

class LicenceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Infos')->components([
                            IconEntry::make('validated')
                                ->label('Validé FFTT')
                                ->boolean()
                                ->inlineLabel(),
                            IconEntry::make('is_minor')
                                ->label('Mineur')
                                ->boolean()
                                ->inlineLabel(),
                            TextEntry::make('type')
                                ->label('Type')
                                ->inlineLabel(),
                            TextEntry::make('category')
                                ->label('Catégorie')
                                ->inlineLabel(),
                            TextEntry::make('amount')
                                ->label('Montant cotisation')
                                ->money('EUR', divideBy: 100)
                                ->inlineLabel(),
                            TextEntry::make('discounted_amount')
                                ->label('Montant à payer')
                                ->money('EUR', divideBy: 100)
                                ->inlineLabel(),
                            TextEntry::make('remaining_amount')
                                ->label('Reste à charge')
                                ->money('EUR', divideBy: 100)
                                ->inlineLabel(),
                            RepeatableEntry::make('licenceDiscounts')
                                ->label('Réductions appliquées')
                                ->schema([
                                    TextEntry::make('type.name')->label('Type'),
                                    TextEntry::make('amount')->label('Montant')->money('EUR', divideBy: 100),
                                    TextEntry::make('reference')->label('Référence'),
                                ])
                                ->columns(3)
                                ->inlineLabel(),
                            TextEntry::make('observations')
                                ->label('Observations')
                                ->inlineLabel()
                                ->markdown(),
                        ]),
                        Tab::make('Documents')->components([
                            TextEntry::make('image_rights')
                                ->label('Autorisation droit à l\'image')
                                ->badge()
                                ->size(TextSize::Large)
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'Accepté',
                                    LicenceDocumentStatus::REJECTED => 'Refusé',
                                    LicenceDocumentStatus::PENDING => 'En attente',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                                    LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                                    LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                                    LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'success',
                                    LicenceDocumentStatus::REJECTED => 'danger',
                                    LicenceDocumentStatus::PENDING => 'warning',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('exit_authorization')
                                ->label('Autorisation de sortie')
                                ->badge()
                                ->size(TextSize::Large)
                                ->visible(fn (Licence $record) => $record->is_minor)
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'Accepté',
                                    LicenceDocumentStatus::REJECTED => 'Refusé',
                                    LicenceDocumentStatus::PENDING => 'En attente',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                                    LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                                    LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                                    LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'success',
                                    LicenceDocumentStatus::REJECTED => 'danger',
                                    LicenceDocumentStatus::PENDING => 'warning',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('care_authorization')
                                ->label('Autorisation de soins')
                                ->badge()
                                ->size(TextSize::Large)
                                ->visible(fn (Licence $record) => $record->is_minor)
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'Accepté',
                                    LicenceDocumentStatus::REJECTED => 'Refusé',
                                    LicenceDocumentStatus::PENDING => 'En attente',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                                    LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                                    LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                                    LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'success',
                                    LicenceDocumentStatus::REJECTED => 'danger',
                                    LicenceDocumentStatus::PENDING => 'warning',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('transport_authorization')
                                ->label('Autorisation de transport')
                                ->badge()
                                ->size(TextSize::Large)
                                ->visible(fn (Licence $record) => $record->is_minor)
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'Accepté',
                                    LicenceDocumentStatus::REJECTED => 'Refusé',
                                    LicenceDocumentStatus::PENDING => 'En attente',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                                    LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                                    LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                                    LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'success',
                                    LicenceDocumentStatus::REJECTED => 'danger',
                                    LicenceDocumentStatus::PENDING => 'warning',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('medical_certificate')
                                ->label('Certificat médical')
                                ->badge()
                                ->size(TextSize::Large)
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'Accepté',
                                    LicenceDocumentStatus::REJECTED => 'Refusé',
                                    LicenceDocumentStatus::PENDING => 'En attente',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                                    LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                                    LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                                    LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'success',
                                    LicenceDocumentStatus::REJECTED => 'danger',
                                    LicenceDocumentStatus::PENDING => 'warning',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('health_declaration')
                                ->label('Auto-questionnaire de santé')
                                ->badge()
                                ->size(TextSize::Large)
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'Accepté',
                                    LicenceDocumentStatus::REJECTED => 'Refusé',
                                    LicenceDocumentStatus::PENDING => 'En attente',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                                    LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                                    LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                                    LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    LicenceDocumentStatus::ACCEPTED => 'success',
                                    LicenceDocumentStatus::REJECTED => 'danger',
                                    LicenceDocumentStatus::PENDING => 'warning',
                                    LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                                })
                                ->inlineLabel(),
                        ]),
                        Tab::make('Historique')->components([
                            TextEntry::make('created_at')
                                ->label('Créée le')
                                ->dateTime()
                                ->inlineLabel(),
                            TextEntry::make('updated_at')
                                ->label('Modifiée le')
                                ->dateTime()
                                ->inlineLabel(),
                        ]),
                    ]),
            ])->columns(1);
    }
}
