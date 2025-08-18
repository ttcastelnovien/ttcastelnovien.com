<?php

namespace App\Filament\Resources\Clubs\RelationManagers;

use App\Filament\Resources\Halls\HallResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class HallsRelationManager extends RelationManager
{
    protected static string $relationship = 'halls';

    protected static ?string $relatedResource = HallResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
