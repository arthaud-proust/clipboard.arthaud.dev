<?php

namespace Tests\Feature;

use App\Models\Text;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class
TextTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_text(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post('/texts', [
                'content' => 'Lorem ipsum',
            ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas(Text::class, [
            'content' => 'Lorem ipsum',
        ]);
    }

    public function test_can_edit_text(): void
    {
        $user = User::factory()->create();
        $text = Text::factory()->for($user)->create(['content' => 'a']);

        $response = $this
            ->actingAs($user)
            ->put("/texts/$text->id", [
                'content' => 'Lorem ipsum',
            ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas(Text::class, [
            'content' => 'Lorem ipsum',
        ]);
    }

    public function test_cant_edit_text_that_belong_to_other_user(): void
    {
        $anotherUser = User::factory()->create();
        $text = Text::factory()->for($anotherUser)->create(['content' => 'a']);
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put("/texts/$text->id", [
                'content' => 'Lorem ipsum',
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas(Text::class, [
            'content' => 'a',
        ]);
    }

    public function test_can_delete_text(): void
    {
        $user = User::factory()->create();
        $text = Text::factory()->for($user)->create(['content' => 'a']);

        $response = $this
            ->actingAs($user)
            ->delete("/texts/$text->id");

        $response->assertRedirect('/');
        $this->assertDatabaseCount(Text::class, 0);
    }

    public function test_cant_delete_text_that_belong_to_other_user(): void
    {
        $anotherUser = User::factory()->create();
        $text = Text::factory()->for($anotherUser)->create(['content' => 'a']);
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete("/texts/$text->id");

        $response->assertForbidden();
        $this->assertDatabaseHas(Text::class, [
            'content' => 'a',
        ]);
    }
}
