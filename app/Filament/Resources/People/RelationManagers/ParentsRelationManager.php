<?php

namespace App\Filament\Resources\People\RelationManagers;

use App\Filament\Resources\People\PersonResource;
use Filament\Resources\RelationManagers\RelationManager;

class ParentsRelationManager extends RelationManager
{
    protected static string $relationship = 'parents';

    protected static ?string $relatedResource = PersonResource::class;

    protected static ?string $title = 'Parents';

    public function isReadOnly(): bool
    {
        return true;
    }
}
