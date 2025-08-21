<?php

namespace App\Filament\Resources\TrackedMails;

use App\Filament\Enum\NavigationGroup;
use App\Filament\Resources\TrackedMails\Pages\ListTrackedMails;
use App\Filament\Resources\TrackedMails\Tables\TrackedMailsTable;
use App\Models\Meta\TrackedMail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TrackedMailResource extends Resource
{
    protected static ?string $model = TrackedMail::class;

    protected static ?string $modelLabel = 'Email envoyé';

    protected static ?string $pluralModelLabel = 'Emails envoyés';

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::META;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $recordTitleAttribute = 'object';

    public static function table(Table $table): Table
    {
        return TrackedMailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrackedMails::route('/'),
        ];
    }
}
