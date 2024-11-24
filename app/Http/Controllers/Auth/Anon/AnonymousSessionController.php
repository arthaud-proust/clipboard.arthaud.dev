<?php

namespace App\Http\Controllers\Auth\Anon;

use App\Http\Controllers\Controller;
use App\Models\AnonUserToken;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use function redirect;

class AnonymousSessionController extends Controller
{
    public function create(User $user, $token): RedirectResponse|Response
    {
        $anonToken = AnonUserToken::where('token', $token)->firstOrCreate([
            'user_id' => $user->id,
            'token' => $token,
        ]);

        if ($anonToken->validated) {
            Auth::login($user);

            return redirect()->route('home');
        }

        return Inertia::render('Auth/Anon/Login', [
            'token' => $anonToken->token,
        ]);
    }
}
