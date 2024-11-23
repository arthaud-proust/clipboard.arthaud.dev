<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
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

        $response->assertRedirect('/');
        $this->assertCount(1, $user->getMedia());
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

        $response->assertRedirect('/');
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
