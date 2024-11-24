<?php

use App\Cleaners\AnonUserCleaner;
use App\Cleaners\MediaCleaner;
use App\Cleaners\TextCleaner;
use Illuminate\Support\Facades\Artisan;

Artisan::command('text:clean', function () {
    resolve(TextCleaner::class)->clean();
    resolve(MediaCleaner::class)->clean();
    resolve(AnonUserCleaner::class)->clean();
})->everyMinute();
