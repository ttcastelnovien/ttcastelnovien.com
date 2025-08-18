<?php

namespace App\Filament\Resources\Events\Tables;

use App\Enums\UserRole;
use App\Models\Meta\Season;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date')
                    ->sortable(),
                TextColumn::make('groups_count')
                    ->label('Groupes')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('people_count')
                    ->label('Participants')
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
