<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Filament\Resources\People\PersonResource;
use Filament\Resources\RelationManagers\RelationManager;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    protected static ?string $relatedResource = PersonResource::class;

    protected static ?string $title = 'Enfants';

    public function isReadOnly(): bool
    {
        return true;
    }
}
