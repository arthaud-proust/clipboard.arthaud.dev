<?php

use App\Cleaners\TextCleaner;
use Illuminate\Support\Facades\Artisan;

Artisan::command('text:clean', function () {
    resolve(TextCleaner::class)->clean();
})->everyMinute();
