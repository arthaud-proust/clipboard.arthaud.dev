<?php

namespace App\Cleaners;

use App\Models\Media;
use function now;

class MediaCleaner
{
    public function clean(): void
    {
        Media::where('updated_at', '<=', now()->subHour()->toDateTimeString())->delete();
    }
}
