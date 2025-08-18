<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\HumanResource\Person;
use App\Services\ICalGenerator;

class ICalController extends Controller
{
    public function __construct(private readonly ICalGenerator $iCalGenerator) {}

    public function streamPersonCalendar(Person $person)
    {
        $calendar = $this->iCalGenerator->generate($person);

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar; charset=utf-8');
    }

    public function downloadPersonCalendar(Person $person)
    {
        $calendar = $this->iCalGenerator->generate($person);

        return response($calendar->get(), 200, [
            'Content-Type' => 'text/calendar; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="ttcastelnovien.ics"',
        ]);
    }
}
