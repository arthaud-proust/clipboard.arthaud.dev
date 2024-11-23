<?php

namespace Tests\Feature\Media;

use App\Cleaners\MediaCleaner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\TestCase;
use function resolve;

class CleanTest extends TestCase
{
    use RefreshDatabase;

    public function test_clean_all_medias_created_more_than_1_hour_ago(): void
    {
        Storage::fake('local');

        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('test.txt', 1024);

        $this->travel(1)->minute(function () use ($user, $file) {
            $user->addMedia($file)->toMediaCollection();
        });

        $this->travel(1)->hour(function () {
            resolve(MediaCleaner::class)->clean();

            $this->assertCount(1, Media::all());
        });
    }
}
