<?php

namespace App\Cleaners;

use App\Models\User;
use function now;

class AnonUserCleaner
{
    public function clean(): void
    {
        User::anonymous()->where('created_at', '<=', now()->subMinutes(10)->toDateTimeString())->delete();
    }
}
