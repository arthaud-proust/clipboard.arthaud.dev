<?php

namespace App\Http\Controllers;

use App\Data\MediaDto;
use App\Data\TextDto;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use function session;

class HomeController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Home', [
            "texts" => TextDto::collect(Auth::user()->texts()->latest('updated_at')->get()),
            "medias" => MediaDto::collect(Auth::user()->getMedia()->collect()),
            "focusTextId" => session()?->get("focusTextId"),
        ]);
    }
}
