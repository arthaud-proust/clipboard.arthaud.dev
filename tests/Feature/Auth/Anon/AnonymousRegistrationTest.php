<?php

namespace Tests\Feature\Auth\Anon;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnonymousRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_anonymous_users_can_register(): void
    {
        $response = $this->get('/anon/register');

        $this->assertAuthenticated();
        $user = User::first();
        $response->assertRedirect("/anon/$user->id/prompt");
    }
}
