<?php

namespace App\Filament\Resources\Clubs;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\Clubs\Pages\CreateClub;
use App\Filament\Resources\Clubs\Pages\EditClub;
use App\Filament\Resources\Clubs\Pages\ListClubs;
use App\Filament\Resources\Clubs\Pages\ViewClub;
use App\Filament\Resources\Clubs\RelationManagers\HallsRelationManager;
use App\Filament\Resources\Clubs\Schemas\ClubForm;
use App\Filament\Resources\Clubs\Schemas\ClubInfolist;
use App\Filament\Resources\Clubs\Tables\ClubsTable;
use App\Models\Clubs\Club;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $modelLabel = 'Club';

    protected static ?string $pluralModelLabel = 'Clubs';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::META;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    public static function form(Schema $schema): Schema
    {
        return ClubForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ClubInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClubsTable::configure($table)
            ->defaultPaginationPageOption(50);
    }

    public static function getRelations(): array
    {
        return [
            HallsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClubs::route('/'),
            'create' => CreateClub::route('/create'),
            'view' => ViewClub::route('/{record}'),
            'edit' => EditClub::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('halls');
    }
}
