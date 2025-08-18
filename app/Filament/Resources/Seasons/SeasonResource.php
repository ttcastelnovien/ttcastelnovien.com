<?php

namespace App\Filament\Resources\Seasons;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\Seasons\Pages\CreateSeason;
use App\Filament\Resources\Seasons\Pages\EditSeason;
use App\Filament\Resources\Seasons\Pages\ListSeasons;
use App\Filament\Resources\Seasons\Schemas\SeasonForm;
use App\Filament\Resources\Seasons\Tables\SeasonsTable;
use App\Models\Meta\Season;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SeasonResource extends Resource
{
    protected static ?string $model = Season::class;

    protected static ?string $modelLabel = 'Saison';

    protected static ?string $pluralModelLabel = 'Saisons';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::META;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SeasonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeasonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeasons::route('/'),
            'create' => CreateSeason::route('/create'),
        ];
    }
}
