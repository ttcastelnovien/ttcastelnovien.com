<?php

namespace App\Filament\Resources\Licences;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\Licences\Pages\ListLicences;
use App\Filament\Resources\Licences\Pages\ViewLicence;
use App\Filament\Resources\Licences\Schemas\LicenceForm;
use App\Filament\Resources\Licences\Schemas\LicenceInfolist;
use App\Filament\Resources\Licences\Tables\LicenceTable;
use App\Models\Licence\Licence;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LicenceResource extends Resource
{
    protected static ?string $model = Licence::class;

    protected static ?string $modelLabel = 'Licencié';

    protected static ?string $pluralModelLabel = 'Licenciés';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::GESTION_HUMAINE;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?int $navigationSort = 200;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Schema $schema): Schema
    {
        return LicenceForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LicenceInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LicenceTable::configure($table)
            ->defaultPaginationPageOption(50);
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
            'index' => ListLicences::route('/'),
            'view' => ViewLicence::route('/{record}'),
        ];
    }
}
