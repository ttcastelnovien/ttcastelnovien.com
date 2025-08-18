<?php

namespace App\Filament\Resources\MedicalCertificates;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\MedicalCertificates\Pages\ListMedicalCertificates;
use App\Filament\Resources\MedicalCertificates\Schemas\MedicalCertificateForm;
use App\Filament\Resources\MedicalCertificates\Tables\MedicalCertificatesTable;
use App\Models\Licence\MedicalCertificate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MedicalCertificateResource extends Resource
{
    protected static ?string $model = MedicalCertificate::class;

    protected static ?string $modelLabel = 'Certificat médical';

    protected static ?string $pluralModelLabel = 'Certificats médicaux';

    protected static bool $shouldRegisterNavigation = false;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::GESTION_HUMAINE;

    protected static string|BackedEnum|null $navigationIcon = 'maki-doctor';

    protected static ?int $navigationSort = 300;

    protected static ?string $recordTitleAttribute = 'identifier';

    public static function form(Schema $schema): Schema
    {
        return MedicalCertificateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MedicalCertificatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMedicalCertificates::route('/'),
        ];
    }
}
