<?php

namespace Tests\Feature\Auth\Anon;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AnonymousLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_delete_anon_user(): void
    {
        $anonUser = User::createAnonymous();
        Auth::login($anonUser);

        $this->post("/logout");

        $this->assertDatabaseCount(User::class, 0);
    }
}
