<?php

namespace App\Providers;

use App\Stats\SizeTransferredStat;
use App\Stats\TransfersCountStat;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TransfersCountStat::class, function (Application $app) {
            return new TransfersCountStat();
        });

        $this->app->singleton(SizeTransferredStat::class, function (Application $app) {
            return new SizeTransferredStat();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
