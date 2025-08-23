<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Filament\Resources\Licences\LicenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class LicencesRelationManager extends RelationManager
{
    protected static string $relationship = 'licences';

    protected static ?string $relatedResource = LicenceResource::class;

    protected static ?string $title = 'Licences';

    public function isReadOnly(): bool
    {
        return false;
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ])
            ->filters([]);
    }
}
