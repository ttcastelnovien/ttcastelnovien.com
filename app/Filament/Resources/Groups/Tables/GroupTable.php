<?php

namespace App\Filament\Resources\Groups\Tables;

use App\Enums\UserRole;
use App\Models\Meta\Season;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GroupTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable(),
                ColorColumn::make('color')
                    ->label('Couleur'),
                TextColumn::make('people_count')
                    ->label('Membres')
                    ->badge()
                    ->color('gray'),
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
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
