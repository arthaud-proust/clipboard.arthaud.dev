<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class AboutController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('About', [
            'usersCount' => User::count(),
        ]);
    }
}
