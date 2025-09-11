<?php

namespace App\Filament\Resources\LicenceDiscountTypes;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\LicenceDiscountTypes\Pages\ListLicenceDiscountTypes;
use App\Filament\Resources\LicenceDiscountTypes\Schemas\LicenceDiscountTypeForm;
use App\Filament\Resources\LicenceDiscountTypes\Tables\LicenceDiscountTypesTable;
use App\Models\Licence\LicenceDiscountType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class LicenceDiscountTypeResource extends Resource
{
    protected static ?string $model = LicenceDiscountType::class;

    protected static ?string $modelLabel = 'Type de réduction';

    protected static ?string $pluralModelLabel = 'Types de réduction';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::GESTION_HUMAINE;

    protected static string|BackedEnum|null $navigationIcon = 'hugeicons-coupon-02';

    protected static ?int $navigationSort = 500;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return LicenceDiscountTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LicenceDiscountTypesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLicenceDiscountTypes::route('/'),
        ];
    }
}
