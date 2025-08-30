<?php

namespace App\Filament\Resources\LedgerAccounts;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\LedgerAccounts\Pages\ListLedgerAccounts;
use App\Filament\Resources\LedgerAccounts\Pages\ViewLedgerAccount;
use App\Filament\Resources\LedgerAccounts\Schemas\LedgerAccountForm;
use App\Filament\Resources\LedgerAccounts\Schemas\LedgerAccountInfolist;
use App\Filament\Resources\LedgerAccounts\Tables\LedgerAccountTable;
use App\Models\Accounting\LedgerAccount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LedgerAccountResource extends Resource
{
    protected static ?string $model = LedgerAccount::class;

    protected static ?string $modelLabel = 'Compte comptable';

    protected static ?string $pluralModelLabel = 'Comptes comptables';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::COMPTABILITE;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?int $navigationSort = 100;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Schema $schema): Schema
    {
        return LedgerAccountForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LedgerAccountInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LedgerAccountTable::configure($table)
            ->defaultPaginationPageOption(50);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLedgerAccounts::route('/'),
            'view' => ViewLedgerAccount::route('/{record}'),
        ];
    }
}
