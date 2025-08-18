<?php

namespace App\Filament\Resources\Licences\Tables;

use App\Enums\UserRole;
use App\Models\Meta\Season;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LicenceTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('licence_type')
                    ->label('Type')
                    ->searchable(),
                IconColumn::make('validated')
                    ->label('Validé FFTT')
                    ->boolean(),
                CheckboxColumn::make('person.is_minor')
                    ->label('Mineur')
                    ->disabled(),
                IconColumn::make('image_rights')
                    ->label('Droit image')
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
                    ->label('Aut. sortie')
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
                    ->label('Aut. soins')
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
                    ->label('Aut. transport')
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
                    ->label('Auto-questionnaire')
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
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
