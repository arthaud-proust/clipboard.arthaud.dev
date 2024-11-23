<?php

namespace Tests\Feature\Text;

use App\Cleaners\TextCleaner;
use App\Models\Text;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function resolve;

class CleanTest extends TestCase
{
    use RefreshDatabase;

    public function test_clean_all_texts_created_more_than_1_hour_ago(): void
    {
        Text::factory(2)->create();

        $this->travel(1)->minute(function () {
            Text::factory(2)->create();
        });

        $this->travel(1)->hour(function () {
            resolve(TextCleaner::class)->clean();

            $this->assertCount(2, Text::all());
        });
    }
}
