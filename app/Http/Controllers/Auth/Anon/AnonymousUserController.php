<?php

namespace App\Http\Controllers\Auth\Anon;

use App\Data\AnonUserDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use function fake;

class AnonymousUserController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Auth/Anon/Index', [
            'anonUsers' => AnonUserDto::collect(User::anonymous()->latest()->get()),
            'token' => fake()->numerify("####"),
        ]);
    }

    public function store(): RedirectResponse
    {
        $user = User::createAnonymous();

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('anon.prompt', $user);
    }
}
