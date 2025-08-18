<?php

namespace App\Filament\Resources\Groups\RelationManagers;

use App\Filament\Resources\People\PersonResource;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PeopleRelationManager extends RelationManager
{
    protected static string $relationship = 'people';

    protected static ?string $relatedResource = PersonResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                AttachAction::make(),
            ])
            ->recordActions([
                DetachAction::make(),
            ]);
    }
}
