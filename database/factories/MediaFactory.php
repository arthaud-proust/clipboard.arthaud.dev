<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use function config;

class MediaFactory extends Factory
{
    protected $model = Media::class;

    public function definition(): array
    {
        return [
            'model_type' => User::class,
            'model_id' => User::factory(),

            'uuid' => Str::uuid(),
            'collection_name' => 'default',
            'name' => $this->faker->name(),
            'file_name' => $this->faker->name(),
            'mime_type' => null,
            'disk' => config('media-library.disk_name'),
            'conversions_disk' => null,
            'size' => $this->faker->randomNumber(),
            'manipulations' => [],
            'custom_properties' => [],
            'generated_conversions' => [],
            'responsive_images' => [],
            'order_column' => null,
        ];
    }
}
