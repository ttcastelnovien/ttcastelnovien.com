<?php

namespace App\Filament\Resources\Licences\Tables;

use App\Enums\LicenceCategory;
use App\Enums\LicenceType;
use App\Enums\UserRole;
use App\Models\Licence\Licence;
use App\Models\Meta\Season;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LicenceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Prénom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('final_price')
                    ->label('Montant'),
                TextColumn::make('licence_type')
                    ->label('Type')
                    ->formatStateUsing(fn (LicenceType $state) => $state->value)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Cat.')
                    ->formatStateUsing(fn (LicenceCategory $state) => $state->value)
                    ->sortable()
                    ->searchable(),
                CheckboxColumn::make('is_minor')
                    ->label('Mineur')
                    ->disabled(),
                IconColumn::make('image_rights')
                    ->label('Image')
                    ->default('-')
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        true => Heroicon::OutlinedCheckCircle,
                        false => Heroicon::OutlinedXCircle,
                        '-' => Heroicon::OutlinedMinusCircle,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        '-' => 'gray',
                    }),
                IconColumn::make('exit_authorization')
                    ->label('Sortie')
                    ->default('-')
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        true => Heroicon::OutlinedCheckCircle,
                        false => Heroicon::OutlinedXCircle,
                        '-' => Heroicon::OutlinedMinusCircle,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        '-' => 'gray',
                    }),
                IconColumn::make('care_authorization')
                    ->label('Soins')
                    ->default('-')
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        true => Heroicon::OutlinedCheckCircle,
                        false => Heroicon::OutlinedXCircle,
                        '-' => Heroicon::OutlinedMinusCircle,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        '-' => 'gray',
                    }),
                IconColumn::make('transport_authorization')
                    ->label('Transport')
                    ->default('-')
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        true => Heroicon::OutlinedCheckCircle,
                        false => Heroicon::OutlinedXCircle,
                        '-' => Heroicon::OutlinedMinusCircle,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        '-' => 'gray',
                    }),
                IconColumn::make('medical_certificate')
                    ->label('Certificat')
                    ->default('-')
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        true => Heroicon::OutlinedCheckCircle,
                        false => Heroicon::OutlinedXCircle,
                        '-' => Heroicon::OutlinedMinusCircle,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        '-' => 'gray',
                    }),
                IconColumn::make('health_declaration')
                    ->label('Questionnaire')
                    ->default('-')
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        true => Heroicon::OutlinedCheckCircle,
                        false => Heroicon::OutlinedXCircle,
                        '-' => Heroicon::OutlinedMinusCircle,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        true => 'success',
                        false => 'danger',
                        '-' => 'gray',
                    }),
            ])
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
                TernaryFilter::make('is_minor')
                    ->label('Mineur'),
                SelectFilter::make('licence_type')
                    ->label('Type de licence')
                    ->multiple()
                    ->options(LicenceType::class),
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->multiple()
                    ->options(LicenceCategory::class),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query->orderBy('last_name')->orderBy('first_name');
            })
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('print_licence_form')
                        ->label('Imprimer le formulaire')
                        ->color('info')
                        ->icon(Heroicon::OutlinedPrinter)
                        ->url(fn (Licence $record) => route('admin.gen.licence_form', ['licence' => $record]))
                        ->openUrlInNewTab(),
                ])
                    ->color('gray')
                    ->label('Actions')
                    ->button()
                    ->dropdownPlacement('top-end'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
