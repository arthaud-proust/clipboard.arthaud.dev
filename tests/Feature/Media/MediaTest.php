<?php

namespace Tests\Feature\Media;

use App\Models\Media;
use App\Models\User;
use App\Stats\SizeTransferredStat;
use App\Stats\TransfersCountStat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function app;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_media(): void
    {
        $user = User::factory()->create();
        $file = $this->uploadedTextFile();

        $response = $this
            ->actingAs($user)
            ->post('/medias', [
                'file' => $file,
            ]);

        $response->assertRedirect('/home');
        $this->assertDatabaseCount(Media::class, 1);
    }

    public function test_create_media_increase_transfers_count_stat(): void
    {
        $this->assertEquals(0, app(TransfersCountStat::class)->value());

        $user = User::factory()->create();
        $file = $this->uploadedTextFile();

        $this
            ->actingAs($user)
            ->post('/medias', [
                'file' => $file,
            ]);

        $this->assertEquals(1, app(TransfersCountStat::class)->value());
    }

    public function test_create_media_increase_size_transferred_stat(): void
    {
        $this->assertEquals(0, app(SizeTransferredStat::class)->value());

        $user = User::factory()->create();
        $file = $this->uploadedTextFile();
        $fileSize = $file->getSize();

        $response = $this
            ->actingAs($user)
            ->post('/medias', [
                'file' => $file,
            ]);

        $response->assertRedirect('/home');
        $this->assertEquals($fileSize, app(SizeTransferredStat::class)->value());
    }

    public function test_cannot_create_more_than_10_medias(): void
    {
        $user = User::factory()->create();

        Media::factory(10)->create([
            'model_id' => $user->id,
        ]);
        $file = $this->uploadedTextFile();

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
        $user = User::factory()->create();
        $file = $this->uploadedTextFile();
        $media = $user->addMedia($file)->toMediaCollection();

        $response = $this
            ->actingAs($user)
            ->delete("/medias/$media->id");

        $response->assertRedirect('/home');
        $this->assertDatabaseCount(Media::class, 0);
    }

    public function test_cant_delete_media_that_belong_to_other_user(): void
    {
        $anotherUser = User::factory()->create();
        $user = User::factory()->create();
        $file = $this->uploadedTextFile();
        $media = $user->addMedia($file)->toMediaCollection();

        $response = $this
            ->actingAs($anotherUser)
            ->delete("/medias/$media->id");

        $response->assertForbidden();
        $this->assertDatabaseCount(Media::class, 1);
        $media->delete();
    }
}
