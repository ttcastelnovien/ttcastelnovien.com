<?php

namespace App\Filament\Resources\Halls;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\Halls\Pages\CreateHall;
use App\Filament\Resources\Halls\Pages\EditHall;
use App\Filament\Resources\Halls\Pages\ListHalls;
use App\Filament\Resources\Halls\Pages\ViewHall;
use App\Filament\Resources\Halls\Schemas\HallForm;
use App\Filament\Resources\Halls\Schemas\HallInfolist;
use App\Filament\Resources\Halls\Tables\HallsTable;
use App\Models\Clubs\Hall;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HallResource extends Resource
{
    protected static ?string $model = Hall::class;

    protected static ?string $modelLabel = 'Salle';

    protected static ?string $pluralModelLabel = 'Salles';

    protected static bool $shouldRegisterNavigation = false;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::META;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return HallForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HallInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HallsTable::configure($table);
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
            'index' => ListHalls::route('/'),
            'create' => CreateHall::route('/create'),
            'view' => ViewHall::route('/{record}'),
            'edit' => EditHall::route('/{record}/edit'),
        ];
    }
}
