<?php

namespace App\Filament\Exports;

use App\Models\Licence\LicenceDiscount;
use Cknow\Money\Money;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;

class LicenceDiscountExporter extends Exporter
{
    protected static ?string $model = LicenceDiscount::class;

    public function getFormats(): array
    {
        return [ExportFormat::Xlsx];
    }

    public function getFileName(Export $export): string
    {
        return "reductions-{$export->getKey()}";
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('licence.lastname_firstname')->label('Licencié(e)'),
            ExportColumn::make('type.name')->label('Type'),
            ExportColumn::make('amount')->label('Montant')->formatStateUsing(fn (Money $state) => $state->formatByIntl()),
            ExportColumn::make('reference')->label('Référence'),
            ExportColumn::make('created_at')->label('Création')->formatStateUsing(fn (Carbon $state) => $state->isoFormat('DD MMM Y HH:mm')),
            ExportColumn::make('updated_at')->label('Modification')->formatStateUsing(fn (Carbon $state) => $state->isoFormat('DD MMM Y HH:mm')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Liste des réductions appliquées disponible au téléchargement.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' ligne(s) n\'ont pas pu être exportée(s).';
        }

        return $body;
    }
}
