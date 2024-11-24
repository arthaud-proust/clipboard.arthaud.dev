<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Stats\SizeTransferredStat;
use App\Stats\TransfersCountStat;
use Inertia\Inertia;
use function app;

class AboutController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('About', [
            'usersCount' => User::count(),
            'transfersCount' => app(TransfersCountStat::class)->value(),
            'sizeTransferred' => app(SizeTransferredStat::class)->value(),
        ]);
    }
}
