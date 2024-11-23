<?php

namespace Tests\Feature\Media;

use App\Models\Media;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_media(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.txt', 1024);

        $response = $this
            ->actingAs($user)
            ->post('/medias', [
                'file' => $file,
            ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseCount(Media::class, 1);
    }

    public function test_cannot_create_more_than_10_medias(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();

        Media::factory(10)->create([
            'model_id' => $user->id,
        ]);
        $file = UploadedFile::fake()->create('test.txt', 1024);

        $response = $this
            ->actingAs($user)
            ->post('/medias', [
                'file' => $file,
            ]);

        $response->assertForbidden();
        $this->assertCount(10, $user->getMedia());
    }

    public function test_can_delete_media(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.txt', 1024);
        $media = $user->addMedia($file)->toMediaCollection();

        $response = $this
            ->actingAs($user)
            ->delete("/medias/$media->id");

        $response->assertRedirect('/home');
        $this->assertDatabaseCount(Media::class, 0);
    }

    public function test_cant_delete_media_that_belong_to_other_user(): void
    {
        Storage::fake('local');

        $anotherUser = User::factory()->create();
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.txt', 1024);
        $media = $user->addMedia($file)->toMediaCollection();

        $response = $this
            ->actingAs($anotherUser)
            ->delete("/medias/$media->id");

        $response->assertForbidden();
        $this->assertDatabaseCount(Media::class, 1);
        $media->delete();
    }
}
