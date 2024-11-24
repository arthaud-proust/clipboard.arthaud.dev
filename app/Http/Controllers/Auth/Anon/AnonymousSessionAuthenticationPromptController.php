<?php

namespace App\Http\Controllers\Auth\Anon;

use App\Data\AnonTokenDto;
use App\Data\AnonUserDto;
use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;

class AnonymousSessionAuthenticationPromptController extends Controller
{
    public function __invoke(User $user)
    {
        return Inertia::render('Auth/Anon/Prompt', [
            'anonUser' => AnonUserDto::from($user),
            'anonTokens' => AnonTokenDto::collect($user->anonTokens),
        ]);
    }
}
