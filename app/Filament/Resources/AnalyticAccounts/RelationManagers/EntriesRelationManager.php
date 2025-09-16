<?php

namespace App\Filament\Resources\AnalyticAccounts\RelationManagers;

use App\Filament\Resources\AnalyticAccountEntries\AnalyticAccountEntryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class EntriesRelationManager extends RelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $relatedResource = AnalyticAccountEntryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
