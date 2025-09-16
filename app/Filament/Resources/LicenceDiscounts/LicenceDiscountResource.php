<?php

namespace App\Filament\Resources\LicenceDiscounts;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\LicenceDiscounts\Pages\ListLicenceDiscounts;
use App\Filament\Resources\LicenceDiscounts\Tables\LicenceDiscountsTable;
use App\Models\Licence\LicenceDiscount;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

class LicenceDiscountResource extends Resource
{
    protected static ?string $model = LicenceDiscount::class;

    protected static ?string $modelLabel = 'Réduction';

    protected static ?string $pluralModelLabel = 'Réductions';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::GESTION_HUMAINE;

    protected static string|BackedEnum|null $navigationIcon = 'hugeicons-coupon-percent';

    protected static ?int $navigationSort = 500;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function table(Table $table): Table
    {
        return LicenceDiscountsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLicenceDiscounts::route('/'),
        ];
    }
}
