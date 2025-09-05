<?php

namespace App\Filament\Resources\People\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class PersonInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Identité')->components([
                            TextEntry::make('firstname')->label('Prénom')->inlineLabel(),
                            TextEntry::make('lastname')->label('Nom')->inlineLabel(),
                            TextEntry::make('sex')->label('Sexe')->inlineLabel(),
                            TextEntry::make('birth_name')->label('Nom de naissance')->inlineLabel(),
                            TextEntry::make('birth_date')->date()->label('Date de naissance')->inlineLabel(),
                            TextEntry::make('birth_city')->label('Lieu de naissance')->inlineLabel(),
                        ]),
                        Tab::make('Coordonnées')->components([
                            TextEntry::make('email')->label('Adresse e-mail')->inlineLabel(),
                            TextEntry::make('phone')->label('Téléphone')->formatStateUsing(function (?string $state): ?string {
                                return $state
                                    ? trim(implode(' ', str_split(preg_replace('/\D+/', '', $state), 2)))
                                    : null;
                            })->inlineLabel(),
                            TextEntry::make('full_address')->label('Adresse')->inlineLabel()->html(),
                        ]),
                        Tab::make('Administratif')->components([
                            TextEntry::make('licence_number')->label('Numéro de licence')->inlineLabel()->copyable(),
                            TextEntry::make('last_image_rights_authorization_date')->label('Date du dernier droit à l\'image')->date()->inlineLabel(),
                            TextEntry::make('nationality')->label('Nationalité')->inlineLabel(),
                            TextEntry::make('father_name')->label('Nom du père si pas FR')->inlineLabel(),
                            TextEntry::make('mother_name')->label('Nom de la mère si pas FR')->inlineLabel(),
                            TextEntry::make('clothing_size')->label('Taille de vêtement')->inlineLabel(),
                            TextEntry::make('pants_size')->label('Taille de pantalon')->inlineLabel(),
                        ]),
                        Tab::make('Historique')->components([
                            TextEntry::make('created_at')->dateTime()->label('Créée le')->inlineLabel(),
                            TextEntry::make('updated_at')->dateTime()->label('Modifiée le')->inlineLabel(),
                        ]),
                    ]),
            ])->columns(1);
    }
}
