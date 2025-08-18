<?php

namespace App\Filament\Resources\Groups;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\Groups\Pages\ListGroups;
use App\Filament\Resources\Groups\Pages\ViewGroup;
use App\Filament\Resources\Groups\RelationManagers\PeopleRelationManager;
use App\Filament\Resources\Groups\Schemas\GroupForm;
use App\Filament\Resources\Groups\Schemas\GroupInfolist;
use App\Filament\Resources\Groups\Tables\GroupTable;
use App\Models\Communication\Group;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $modelLabel = 'Groupe';

    protected static ?string $pluralModelLabel = 'Groupes';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::COMMUNICATION;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 100;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return GroupForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GroupInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GroupTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            PeopleRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGroups::route('/'),
            'view' => ViewGroup::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('people');
    }
}
