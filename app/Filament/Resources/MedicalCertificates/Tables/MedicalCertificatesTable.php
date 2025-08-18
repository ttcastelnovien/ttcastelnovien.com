<?php

namespace App\Filament\Resources\MedicalCertificates\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MedicalCertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor_name')
                    ->label('Nom du docteur')
                    ->searchable(),
                TextColumn::make('doctor_identifier')
                    ->label('Identifiant RPPS du docteur')
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Date du certificat')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                    Action::make('Télécharger')
                        ->icon(Heroicon::ArrowDownTray)
                        ->url(fn ($record) => Storage::disk('certificates')->temporaryUrl($record->file, now()->addMinutes(30)->endOfHour()))
                        ->openUrlInNewTab(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
