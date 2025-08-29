<?php

namespace App\Filament\Resources\People;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\People\Pages\ListPeople;
use App\Filament\Resources\People\Pages\ViewPerson;
use App\Filament\Resources\People\RelationManagers\ChildrenRelationManager;
use App\Filament\Resources\People\RelationManagers\LicencesRelationManager;
use App\Filament\Resources\People\RelationManagers\MedicalCertificatesRelationManager;
use App\Filament\Resources\People\RelationManagers\ParentsRelationManager;
use App\Filament\Resources\People\Schemas\PersonForm;
use App\Filament\Resources\People\Schemas\PersonInfolist;
use App\Filament\Resources\People\Tables\PeopleTable;
use App\Models\HumanResource\Person;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PersonResource extends Resource
{
    protected static ?string $model = Person::class;

    protected static ?string $modelLabel = 'Personne';

    protected static ?string $pluralModelLabel = 'Personnes';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::GESTION_HUMAINE;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    protected static ?int $navigationSort = 100;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Schema $schema): Schema
    {
        return PersonForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PersonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PeopleTable::configure($table)
            ->defaultPaginationPageOption(50);
    }

    public static function getRelations(): array
    {
        return [
            LicencesRelationManager::class,
            MedicalCertificatesRelationManager::class,
            ParentsRelationManager::class,
            ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPeople::route('/'),
            'view' => ViewPerson::route('/{record}'),
        ];
    }
}
