<?php

namespace App\Filament\Resources\AnalyticAccounts;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\AnalyticAccounts\Pages\ListAnalyticAccounts;
use App\Filament\Resources\AnalyticAccounts\Pages\ViewAnalyticAccount;
use App\Filament\Resources\AnalyticAccounts\RelationManagers\EntriesRelationManager;
use App\Filament\Resources\AnalyticAccounts\Schemas\AnalyticAccountForm;
use App\Filament\Resources\AnalyticAccounts\Schemas\AnalyticAccountInfolist;
use App\Filament\Resources\AnalyticAccounts\Tables\AnalyticAccountsTable;
use App\Models\Accounting\AnalyticAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AnalyticAccountResource extends Resource
{
    protected static ?string $model = AnalyticAccount::class;

    protected static ?string $modelLabel = 'Compte analytique';

    protected static ?string $pluralModelLabel = 'Comptes analytiques';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::COMPTABILITE;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartPie;

    protected static ?int $navigationSort = 300;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return AnalyticAccountForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AnalyticAccountInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnalyticAccountsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EntriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnalyticAccounts::route('/'),
            'view' => ViewAnalyticAccount::route('/{record}'),
        ];
    }
}
