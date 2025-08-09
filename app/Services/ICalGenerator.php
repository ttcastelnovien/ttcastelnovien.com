<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class ICalGenerator
{
    public function generate(User $user): Calendar
    {
        $calendar = Calendar::create('TTCastelnovien');

        $userEvents = $user->events()->get();
        $groupsEvents = $user->groups()->with('events')->get()->flatMap(function ($group) {
            return $group->events;
        });

        $events = $userEvents->merge($groupsEvents)->unique('id');
        $homeLocation = Location::firstWhere('name', 'Châteauneuf TT Castelnovien');

        foreach ($events as $event) {
            $event->load('location');

            $calendar->event(function (Event $ev) use ($event, $homeLocation) {
                /**
                 * On gère en premier lieu les propriétés évidentes.
                 */
                $ev
                    ->name($event->title)
                    ->url(route('events.show', ['event' => $event->id]));

                /**
                 * On gère la description de l'événement.
                 * Si l'événement a une description, on l'utilise.
                 * Si l'événement a des informations complémentaires,
                 * on les rajoute à la description.
                 */
                $description = $event->description ?: '';
                $complementaryInfo = [];

                if ($event->opponent) {
                    $complementaryInfo[] = "→ Adversaire : " . $event->opponent;
                }

                if ($event->check_in_time) {
                    $complementaryInfo[] = "→ Heure de pointage : " . $event->check_in_time->format('H:i');
                }

                if ($event->departure_time) {
                    $complementaryInfo[] = "→ Heure de départ : " . $event->departure_time->format('H:i');
                }

                $ev->description($description . "\n\n" . implode("\n", $complementaryInfo));

                /**
                 * Si l'événement ne contient pas d'heure, on le considère
                 * comme un événement sur une ou plusieurs journées.
                 */
                if ($event->isAllDay()) {
                    $ev->startsAt($event->start_date);

                    /**
                     * Si l'événement ne définit pas de date de fin,
                     * on utilise la date de début.
                     */
                    if ($event->end_date) {
                        $ev->endsAt($event->end_date);
                    } else {
                        $ev->endsAt($event->start_date);
                    }
                } else {
                    $ev->startsAt(Carbon::create(
                        year: $event->start_date->year,
                        month: $event->start_date->month,
                        day: $event->start_date->day,
                        hour: $event->start_time ? $event->start_time->hour : 0,
                        minute: $event->start_time ? $event->start_time->minute : 0,
                    ));

                    $ev->endsAt(Carbon::create(
                        year: $event->end_date->year,
                        month: $event->end_date->month,
                        day: $event->end_date->day,
                        hour: $event->end_time ? $event->end_time->hour : 0,
                        minute: $event->end_time ? $event->end_time->minute : 0,
                    ));
                }

                /**
                 * - Si l'événement est à domicile, on utilise l'adresse
                 * de la salle.
                 * - Si l'événement n'est pas à domicile et qu'une
                 * adresse a été définie, on utilise l'adresse
                 * de l'événement.
                 */
                $eventLocation = $event->location ?: $homeLocation;
                $location = $eventLocation->addressLine1;

                if ($eventLocation->addressLine2) {
                    $location .= ', ' . $eventLocation->addressLine2;
                }

                if ($eventLocation->addressLine3) {
                    $location .= ', ' . $eventLocation->addressLine3;
                }

                $location .= ', ' . $eventLocation->postal_code . ' ' . $eventLocation->city;
                $ev->address($location);

                if ($eventLocation->latitude && $eventLocation->longitude) {
                    $ev->coordinates($eventLocation->latitude, $eventLocation->longitude);
                }

                /**
                 * Si l'événement a des pièces jointes, on les ajoute
                 * par un lien public à l'événement.
                 */
                if ($event->attachments) {
                    foreach ($event->attachments as $attachment) {
                        $ev->attachment(Storage::url($attachment));
                    }
                }
            });
        }

        return $calendar;
    }
}
