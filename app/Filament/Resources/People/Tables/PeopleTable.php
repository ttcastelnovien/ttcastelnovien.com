<?php

namespace App\Filament\Resources\People\Tables;

use App\Enums\MailObject;
use App\Enums\UserRole;
use App\Models\HumanResource\Person;
use App\Models\Security\Invitation;
use App\Services\Mailer\Recipient;
use App\Services\Mailer\TransactionalMailer;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\URL;

class PeopleTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('licence_number')
                    ->label('N° licence')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->label('Prénom')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label('Nom')
                    ->searchable(),
                TextColumn::make('sex')
                    ->label('Sexe')
                    ->searchable(),
                CheckboxColumn::make('is_minor')
                    ->label('Mineur')
                    ->disabled(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Téléphone')
                    ->formatStateUsing(fn (string $state) => preg_replace('/(\d{2})(?=\d)/', '$1 ', $state))
                    ->searchable(),
            ])
            ->filters([])
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
                                    recipients: [new Recipient($recipient->email, $recipient->full_name)],
                                    data: [
                                        'firstname' => $person->first_name,
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
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
