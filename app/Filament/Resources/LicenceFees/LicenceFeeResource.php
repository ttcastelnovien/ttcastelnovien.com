<?php

namespace App\Filament\Resources\LicenceFees;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\LicenceFees\Pages\ListLicenceFees;
use App\Filament\Resources\LicenceFees\Schemas\LicenceFeeForm;
use App\Filament\Resources\LicenceFees\Tables\LicenceFeeTable;
use App\Models\Licence\LicenceFee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LicenceFeeResource extends Resource
{
    protected static ?string $model = LicenceFee::class;

    protected static ?string $modelLabel = 'Tarif de licence';

    protected static ?string $pluralModelLabel = 'Tarifs de licence';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::SPORTIF;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?int $navigationSort = 200;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LicenceFeeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LicenceFeeTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLicenceFees::route('/'),
        ];
    }
}
