<?php

namespace App\Filament\Resources\Licences\Schemas;

use Filament\Infolists\Components\IconEntry;
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
                            TextEntry::make('licence_type')
                                ->label('Type')
                                ->inlineLabel(),
                            TextEntry::make('category')
                                ->label('Catégorie')
                                ->inlineLabel(),
                            IconEntry::make('is_minor')
                                ->label('Mineur')
                                ->boolean()
                                ->inlineLabel(),
                            IconEntry::make('validated')
                                ->label('Validé FFTT')
                                ->boolean()
                                ->inlineLabel(),
                            TextEntry::make('image_rights')
                                ->label('Autorisation droit à l\'image')
                                ->badge()
                                ->size(TextSize::Large)
                                ->default('-')
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    true => 'Reçu',
                                    false => 'En attente',
                                    default => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    true => Heroicon::OutlinedCheckCircle,
                                    false => Heroicon::OutlinedXCircle,
                                    default => Heroicon::OutlinedMinusCircle,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    true => 'success',
                                    false => 'danger',
                                    '-' => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('exit_authorization')
                                ->label('Autorisation de sortie')
                                ->badge()
                                ->size(TextSize::Large)
                                ->default('-')
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    true => 'Reçu',
                                    false => 'En attente',
                                    default => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    true => Heroicon::OutlinedCheckCircle,
                                    false => Heroicon::OutlinedXCircle,
                                    default => Heroicon::OutlinedMinusCircle,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    true => 'success',
                                    false => 'danger',
                                    '-' => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('care_authorization')
                                ->label('Autorisation de soins')
                                ->badge()
                                ->size(TextSize::Large)
                                ->default('-')
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    true => 'Reçu',
                                    false => 'En attente',
                                    default => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    true => Heroicon::OutlinedCheckCircle,
                                    false => Heroicon::OutlinedXCircle,
                                    default => Heroicon::OutlinedMinusCircle,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    true => 'success',
                                    false => 'danger',
                                    '-' => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('transport_authorization')
                                ->label('Autorisation de transport')
                                ->badge()
                                ->size(TextSize::Large)
                                ->default('-')
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    true => 'Reçu',
                                    false => 'En attente',
                                    default => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    true => Heroicon::OutlinedCheckCircle,
                                    false => Heroicon::OutlinedXCircle,
                                    default => Heroicon::OutlinedMinusCircle,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    true => 'success',
                                    false => 'danger',
                                    '-' => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('medical_certificate')
                                ->label('Certificat médical')
                                ->badge()
                                ->size(TextSize::Large)
                                ->default('-')
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    true => 'Reçu',
                                    false => 'En attente',
                                    default => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    true => Heroicon::OutlinedCheckCircle,
                                    false => Heroicon::OutlinedXCircle,
                                    default => Heroicon::OutlinedMinusCircle,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    true => 'success',
                                    false => 'danger',
                                    '-' => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('health_declaration')
                                ->label('Auto-questionnaire de santé')
                                ->badge()
                                ->size(TextSize::Large)
                                ->default('-')
                                ->formatStateUsing(fn (mixed $state): string => match ($state) {
                                    true => 'Reçu',
                                    false => 'En attente',
                                    default => 'Non applicable',
                                })
                                ->icon(fn (mixed $state): Heroicon => match ($state) {
                                    true => Heroicon::OutlinedCheckCircle,
                                    false => Heroicon::OutlinedXCircle,
                                    default => Heroicon::OutlinedMinusCircle,
                                })
                                ->color(fn (mixed $state): string => match ($state) {
                                    true => 'success',
                                    false => 'danger',
                                    '-' => 'gray',
                                })
                                ->inlineLabel(),
                            TextEntry::make('observations')
                                ->label('Observations')
                                ->inlineLabel()
                                ->markdown(),
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
