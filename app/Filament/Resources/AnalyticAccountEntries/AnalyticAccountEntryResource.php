<?php

namespace App\Filament\Resources\AnalyticAccountEntries;

use App\Filament\Resources\AnalyticAccountEntries\Pages\ListAnalyticAccountEntries;
use App\Filament\Resources\AnalyticAccountEntries\Schemas\AnalyticAccountEntryForm;
use App\Filament\Resources\AnalyticAccountEntries\Tables\AnalyticAccountEntriesTable;
use App\Models\Accounting\AnalyticAccountEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class AnalyticAccountEntryResource extends Resource
{
    protected static ?string $model = AnalyticAccountEntry::class;

    protected static ?string $modelLabel = 'Entrée analytique';

    protected static ?string $pluralModelLabel = 'Entrées analytiques';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AnalyticAccountEntryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnalyticAccountEntriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnalyticAccountEntries::route('/'),
        ];
    }
}
