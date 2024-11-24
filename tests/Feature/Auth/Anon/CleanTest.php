<?php

namespace Tests\Feature\Auth\Anon;

use App\Cleaners\AnonUserCleaner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function resolve;

class CleanTest extends TestCase
{
    use RefreshDatabase;

    public function test_clean_all_anon_users_created_more_than_10_minutes_ago(): void
    {
        User::factory()->create();
        User::createAnonymous();

        $this->travel(1)->minute(function () {
            User::createAnonymous();
        });

        $this->travel(10)->minutes(function () {
            resolve(AnonUserCleaner::class)->clean();

            $this->assertCount(1, User::anonymous()->get());
            $this->assertCount(2, User::all());
        });
    }
}
