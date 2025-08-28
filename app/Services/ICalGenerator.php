<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Communication\Event;
use App\Models\HumanResource\Person;
use Illuminate\Support\Facades\Storage;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event as CalendarEvent;

class ICalGenerator
{
    public function generate(Person $person): Calendar
    {
        $calendar = Calendar::create('TTCastelnovien');

        $userEvents = $person->events()->get();
        $groupsEvents = $person->groups()->with('events')->get()->flatMap(fn ($group) => $group->events);
        $parentsEvents = $person->parents()->with('events')->get()->flatMap(fn ($parent) => $parent->events);
        $childrenEvents = $person->children()->with('events')->get()->flatMap(fn ($child) => $child->events);
        $parentsGroupsEvents = $person->parents()->with('groups')->get()->flatMap(fn ($parent) => $parent->groups->flatMap(fn ($group) => $group->events));
        $childrenGroupsEvents = $person->children()->with('groups')->get()->flatMap(fn ($child) => $child->groups->flatMap(fn ($group) => $group->events));

        /** @var list<Event> $events */
        $events = $userEvents
            ->merge($groupsEvents)
            ->merge($parentsEvents)
            ->merge($childrenEvents)
            ->merge($parentsGroupsEvents)
            ->merge($childrenGroupsEvents)
            ->unique('id');

        $homeAddress = implode('\n', [
            'Complexe Sportif François Gabart',
            '3 Impasse du Chemin Piquet',
            '16120 Châteauneuf-sur-Charente',
        ]);

        $homeCoordinates = [45.593205, -0.0544517];

        foreach ($events as $event) {
            $calendar->event(function (CalendarEvent $ev) use ($event, $homeAddress, $homeCoordinates) {
                /**
                 * On gère en premier lieu les propriétés évidentes.
                 */
                $ev->name($event->title);
                // $ev->url(route('events.show', ['event' => $event->id]));

                /**
                 * On gère la description de l'événement.
                 * Si l'événement a une description, on l'utilise.
                 * Si l'événement a des informations complémentaires,
                 * on les rajoute à la description.
                 */
                $description = $event->description ?: '';
                $complementaryInfo = [];

                if ($event->opponent) {
                    $complementaryInfo[] = sprintf('→ Adversaire : %s', $event->opponent);
                }

                if ($event->check_in_time) {
                    $complementaryInfo[] = sprintf('→ Heure de pointage : %s', $event->check_in_time);
                }

                if ($event->departure_time) {
                    $complementaryInfo[] = sprintf('→ Heure de départ : %s', $event->departure_time);
                }

                $ev->description(sprintf(
                    '%s\n\n%s',
                    str($description)->markdown()->sanitizeHtml()->toString(),
                    implode("\n", $complementaryInfo)
                ));

                $ev->startsAt($event->start, withTime: $event->start_time !== null);

                if (! is_null($event->end)) {
                    $ev->endsAt($event->end, withTime: $event->end_time !== null);
                }

                /**
                 * - Si l'événement est à domicile, on utilise l'adresse
                 * de la salle.
                 * - Si l'événement n'est pas à domicile et qu'une
                 * adresse a été définie, on utilise l'adresse
                 * de l'événement.
                 */
                $address = $event->address ?: $homeAddress;

                $ev->address($address);

                if (is_null($event->latitude) || is_null($event->longitude)) {
                    $ev->coordinates($homeCoordinates[0], $homeCoordinates[1]);
                } else {
                    $ev->coordinates($event->latitude, $event->longitude);
                }

                /**
                 * Si l'événement a des pièces jointes, on les ajoute
                 * par un lien public à l'événement.
                 */
                if ($event->attachments) {
                    foreach ($event->attachments as $attachment) {
                        $ev->attachment(Storage::disk('public')->url($attachment));
                    }
                }
            });
        }

        return $calendar;
    }
}
