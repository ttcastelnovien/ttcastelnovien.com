<?php

namespace App\Filament\Resources\LicenceDiscounts\Tables;

use App\Enums\UserRole;
use App\Filament\Exports\LicenceDiscountExporter;
use App\Models\Meta\Season;
use Filament\Actions\ExportBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LicenceDiscountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('licence.lastname_firstname')
                    ->label('Licencié(e)')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('type.name')
                    ->label('Type')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Montant')
                    ->money('EUR', divideBy: 100)
                    ->sortable(),
                TextColumn::make('reference')->label('Référence'),
                TextColumn::make('created_at')
                    ->label('Création')
                    ->isoDateTime(timezone: 'Europe/Paris')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Modification')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query->orderBy('created_at', 'desc');
            })
            ->filters([
                SelectFilter::make('season')
                    ->label('Saison')
                    ->relationship('season', 'name', function (Builder $query): Builder {
                        if (auth()->user()->hasRole(UserRole::HISTORY)) {
                            return $query->orderBy('name');
                        }

                        return $query->where('id', '=', Season::current()->first()->id);
                    })
                    ->preload()
                    ->selectablePlaceholder(false)
                    ->default(Season::current()->first()->id),
                SelectFilter::make('type')
                    ->label('Type')
                    ->relationship('type', 'name')
                    ->preload(),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([
                ExportBulkAction::make('export')
                    ->label('Exporter')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->exporter(LicenceDiscountExporter::class),
            ]);
    }
}
