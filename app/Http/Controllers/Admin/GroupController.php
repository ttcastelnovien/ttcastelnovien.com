<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Communication\Group;

class GroupController extends Controller
{
    public function index()
    {
        $groups = Group::withCount('people')->get()->sortBy('name')->all();
        dd($groups);
    }
}
