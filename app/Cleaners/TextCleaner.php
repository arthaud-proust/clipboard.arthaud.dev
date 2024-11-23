<?php

namespace App\Cleaners;

use App\Models\Text;
use function now;

class TextCleaner
{
    public function clean(): void
    {
        Text::where('updated_at', '<=', now()->subHour()->toDateTimeString())->delete();
    }
}
