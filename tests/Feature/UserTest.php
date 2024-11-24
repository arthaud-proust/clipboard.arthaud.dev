<?php

namespace Tests\Feature\Media;

use App\Models\Media;
use App\Models\Text;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_user_should_delete_its_texts(): void
    {
        $user = User::factory()->create();
        Text::factory()->for($user)->create();

        $this->assertDatabaseCount(Text::class, 1);

        $user->delete();

        $this->assertDatabaseCount(Text::class, 0);
    }

    public function test_delete_user_should_delete_its_medias(): void
    {
        $user = User::factory()->create();
        Media::factory()->create([
            'model_id' => $user->id,
        ]);

        $this->assertDatabaseCount(Media::class, 1);

        $user->delete();

        $this->assertDatabaseCount(Media::class, 0);
    }
}

