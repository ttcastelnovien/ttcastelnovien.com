<?php

namespace App\Filament\Resources\Licences\Tables;

use App\Enums\LicenceCategory;
use App\Enums\LicenceDocumentStatus;
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
use Filament\Tables\Columns\ToggleColumn;
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
                TextColumn::make('lastname')
                    ->label('Nom')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('firstname')
                    ->label('Prénom')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('validated')
                    ->label('FFTT')
                    ->toggleable(),
                TextColumn::make('amount')
                    ->label('Montant cotisation')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money('EUR', divideBy: 100),
                TextColumn::make('discounted_amount')
                    ->label('Montant à payer')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->money('EUR', divideBy: 100),
                TextColumn::make('remaining_amount')
                    ->label('Reste à charge')
                    ->toggleable()
                    ->money('EUR', divideBy: 100),
                TextColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn (LicenceType $state) => $state->value)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Cat.')
                    ->formatStateUsing(fn (LicenceCategory $state) => $state->value)
                    ->sortable()
                    ->toggleable()
                    ->searchable(),
                CheckboxColumn::make('is_minor')
                    ->label('Mineur')
                    ->toggleable()
                    ->disabled(),
                IconColumn::make('image_rights')
                    ->label('Image')
                    ->toggleable()
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                        LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                        LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                        LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => 'success',
                        LicenceDocumentStatus::REJECTED => 'danger',
                        LicenceDocumentStatus::PENDING => 'warning',
                        LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                    }),
                IconColumn::make('exit_authorization')
                    ->label('Sortie')
                    ->toggleable()
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                        LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                        LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                        LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => 'success',
                        LicenceDocumentStatus::REJECTED => 'danger',
                        LicenceDocumentStatus::PENDING => 'warning',
                        LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                    }),
                IconColumn::make('care_authorization')
                    ->label('Soins')
                    ->toggleable()
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                        LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                        LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                        LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => 'success',
                        LicenceDocumentStatus::REJECTED => 'danger',
                        LicenceDocumentStatus::PENDING => 'warning',
                        LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                    }),
                IconColumn::make('transport_authorization')
                    ->label('Transport')
                    ->toggleable()
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                        LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                        LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                        LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => 'success',
                        LicenceDocumentStatus::REJECTED => 'danger',
                        LicenceDocumentStatus::PENDING => 'warning',
                        LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                    }),
                IconColumn::make('medical_certificate')
                    ->label('Certificat')
                    ->toggleable()
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                        LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                        LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                        LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => 'success',
                        LicenceDocumentStatus::REJECTED => 'danger',
                        LicenceDocumentStatus::PENDING => 'warning',
                        LicenceDocumentStatus::NOT_NECESSARY => 'gray',
                    }),
                IconColumn::make('health_declaration')
                    ->label('Questionnaire')
                    ->toggleable()
                    ->icon(fn (mixed $state): Heroicon => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => Heroicon::OutlinedCheck,
                        LicenceDocumentStatus::REJECTED => Heroicon::OutlinedXMark,
                        LicenceDocumentStatus::PENDING => Heroicon::OutlinedArrowPath,
                        LicenceDocumentStatus::NOT_NECESSARY => Heroicon::OutlinedMinus,
                    })
                    ->color(fn (mixed $state): string => match ($state) {
                        LicenceDocumentStatus::ACCEPTED => 'success',
                        LicenceDocumentStatus::REJECTED => 'danger',
                        LicenceDocumentStatus::PENDING => 'warning',
                        LicenceDocumentStatus::NOT_NECESSARY => 'gray',
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
                SelectFilter::make('type')
                    ->label('Type de licence')
                    ->multiple()
                    ->options(LicenceType::class),
                SelectFilter::make('category')
                    ->label('Catégorie')
                    ->multiple()
                    ->options(LicenceCategory::class),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query->orderBy('lastname')->orderBy('firstname');
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
                    Action::make('send_attestation')
                        ->label('Envoyer l\'attestation')
                        ->color('info')
                        ->icon(Heroicon::OutlinedEnvelopeOpen)
                        ->url(fn (Licence $record) => route('admin.gen.licence_attestation', ['licence' => $record])),
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
