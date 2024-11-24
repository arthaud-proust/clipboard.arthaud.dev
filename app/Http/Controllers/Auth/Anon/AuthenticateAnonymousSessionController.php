<?php

namespace App\Http\Controllers\Auth\Anon;

use App\Http\Controllers\Controller;
use App\Models\AnonUserToken;
use App\Models\User;
use Illuminate\Http\Request;
use function redirect;

class AuthenticateAnonymousSessionController extends Controller
{
    public function __invoke(User $user, AnonUserToken $token, Request $request)
    {
        if ($request->user()->isNot($user)) {
            abort(403);
        }

        $token->update([
            'validated' => true,
        ]);

        return redirect()->route('home');
    }
}
