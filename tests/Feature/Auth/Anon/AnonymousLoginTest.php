<?php

namespace Tests\Feature\Auth\Anon;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnonymousLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_do_not_login_if_token_is_not_validated(): void
    {
        $anonUser = User::createAnonymous();

        $this->get("/anon/$anonUser->id/login/490");

        $this->assertGuest();
    }

    public function test_only_logged_anon_user_can_authenticate(): void
    {
        $anonUser = User::createAnonymous();
        $otherAnonUser = User::createAnonymous();

        $this->get("/anon/$anonUser->id/login/490");

        $asGuest = $this->get("/anon/$anonUser->id/authenticate/490");
        $asGuest->assertRedirect('/login');

        $asOtherAnon = $this->actingAs($otherAnonUser)->get("/anon/$anonUser->id/authenticate/490");
        $asOtherAnon->assertForbidden();
    }

    public function test_login_if_token_is_validated(): void
    {
        $anonUser = User::createAnonymous();

        $this->get("/anon/$anonUser->id/login/490");

        $this->actingAs($anonUser)->get("/anon/$anonUser->id/authenticate/490");

        $response = $this->get("/anon/$anonUser->id/login/490");

        $this->assertAuthenticated();
        $response->assertRedirect("/home");
    }

}
