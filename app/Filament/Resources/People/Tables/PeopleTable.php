<?php

namespace App\Filament\Resources\People\Tables;

use App\Enums\MailObject;
use App\Enums\Sex;
use App\Enums\UserRole;
use App\Models\HumanResource\Person;
use App\Models\Security\Invitation;
use App\Services\Mailer\Recipient;
use App\Services\Mailer\TransactionalMailer;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\URL;

class PeopleTable
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
                TextColumn::make('sex')
                    ->label('Sexe')
                    ->searchable(),
                CheckboxColumn::make('is_minor')
                    ->label('Mineur')
                    ->disabled(),
            ])
            ->filters([
                TernaryFilter::make('is_minor')
                    ->label('Mineur')
                    ->queries(
                        true: fn (Builder $query) => $query->where('birth_date', '>', now()->subYears(19)),
                        false: fn (Builder $query) => $query->where('birth_date', '<=', now()->subYears(19)),
                    ),
                SelectFilter::make('sex')
                    ->options(Sex::class)
                    ->label('Sexe'),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query->orderBy('lastname')->orderBy('firstname');
            })
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('Inviter')
                        ->label('Inviter')
                        ->icon(Heroicon::OutlinedEnvelopeOpen)
                        ->color('info')
                        ->requiresConfirmation()
                        ->visible(fn (Person $record) => $record->email !== null || $record->parents->isNotEmpty())
                        ->action(function (Person $person) {
                            /** @var list<Person> $recipients */
                            $recipients = [];

                            if ($person->is_minor && $person->parents->isNotEmpty()) {
                                $recipients = [$recipients, ...$person->parents->all()];
                            }

                            if ($person->email !== null) {
                                $recipients[] = $person;
                            }

                            if (count($recipients) === 0) {
                                return;
                            }

                            $invitation = Invitation::create([
                                'person_id' => $person->id,
                                'roles' => [UserRole::USER],
                                'expires_at' => now()->addDays(7),
                            ]);

                            foreach ($recipients as $recipient) {
                                TransactionalMailer::send(
                                    object: MailObject::INVITATION,
                                    recipients: [new Recipient($recipient->email, $recipient->firstname_lastname)],
                                    data: [
                                        'firstname' => $person->firstname,
                                        'email' => $recipient->email,
                                        'confirm_url' => URL::signedRoute(
                                            name: 'public.invite.show',
                                            parameters: ['invitation' => $invitation],
                                            expiration: now()->addDays(7),
                                        ),
                                    ],
                                );
                            }
                        }),
                ])
                    ->label('Actions')
                    ->button()
                    ->color('gray')
                    ->dropdownPlacement('top-end'),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ]);
    }
}
