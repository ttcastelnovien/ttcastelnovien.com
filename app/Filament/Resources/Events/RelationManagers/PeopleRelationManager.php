<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Resources\People\PersonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class PeopleRelationManager extends RelationManager
{
    protected static string $relationship = 'people';

    protected static ?string $relatedResource = PersonResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
