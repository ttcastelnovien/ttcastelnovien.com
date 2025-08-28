<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nom')
                    ->inlineLabel(),
                TextEntry::make('code')
                    ->label('Code')
                    ->inlineLabel(),
            ])->columns(1);
    }
}
