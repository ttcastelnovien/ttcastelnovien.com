<?php

namespace App\Filament\Resources\People\Schemas;

use App\Filament\Resources\People\PersonResource;
use App\Filament\Resources\People\RelationManagers\MedicalCertificatesRelationManager;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PersonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Identité')->components([
                            TextEntry::make('first_name')->label('Prénom')->inlineLabel(),
                            TextEntry::make('last_name')->label('Nom')->inlineLabel(),
                            TextEntry::make('sex')->label('Sexe')->inlineLabel(),
                            TextEntry::make('birth_name')->label('Nom de naissance')->inlineLabel(),
                            TextEntry::make('birth_date')->date()->label('Date de naissance')->inlineLabel(),
                            TextEntry::make('birth_city')->label('Lieu de naissance')->inlineLabel(),
                        ]),
                        Tab::make('Coordonnées')->components([
                            TextEntry::make('email')->label('Adresse e-mail')->inlineLabel(),
                            TextEntry::make('phone')->label('Téléphone')->inlineLabel(),
                            TextEntry::make('full_address')->label('Adresse')->inlineLabel()->html(),
                        ]),
                        Tab::make('Administratif')->components([
                            TextEntry::make('licence_number')->label('Numéro de licence')->inlineLabel()->copyable(),
                            TextEntry::make('last_image_rights_authorization_date')->label('Date du dernier droit à l\'image')->date()->inlineLabel(),
                            TextEntry::make('nationality')->label('Nationalité')->inlineLabel(),
                            TextEntry::make('father_name')->label('Nom du père si pas FR')->inlineLabel(),
                            TextEntry::make('mother_name')->label('Nom de la mère si pas FR')->inlineLabel(),
                        ]),
                        Tab::make('Famille')->components([
                            TextEntry::make('parents_links')
                                ->label('Parents')
                                ->inlineLabel()
                                ->html()
                                ->state(function ($record): string {
                                    $links = $record->parents->map(function ($parent) {
                                        return sprintf(
                                            '<a href="%s">%s</a>',
                                            PersonResource::getUrl('view', ['record' => $parent]),
                                            e($parent->full_name),
                                        );
                                    })->implode('<br>');

                                    return $links !== '' ? $links : 'Aucun';
                                }),
                            TextEntry::make('children_links')
                                ->label('Enfants')
                                ->inlineLabel()
                                ->html()
                                ->state(function ($record): string {
                                    $links = $record->children->map(function ($child) {
                                        return sprintf(
                                            '<a href="%s">%s</a>',
                                            PersonResource::getUrl('view', ['record' => $child]),
                                            e($child->full_name),
                                        );
                                    })->implode('<br>');

                                    return $links !== '' ? $links : 'Aucun';
                                }),
                        ]),
                        Tab::make('Historique')->components([
                            TextEntry::make('created_at')->dateTime()->label('Créée le')->inlineLabel(),
                            TextEntry::make('updated_at')->dateTime()->label('Modifiée le')->inlineLabel(),
                        ]),
                    ]),
            ])->columns(1);
    }
}
