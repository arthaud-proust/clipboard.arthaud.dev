<?php

namespace App\Cleaners;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function now;

class MediaCleaner
{
    public function clean(): void
    {
        Media::where('updated_at', '<=', now()->subHour()->toDateTimeString())->delete();
    }
}
