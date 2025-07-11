<?php

namespace App\Providers;

use App\Http\Resources\TransactionResource;
use App\Listeners\CommandStartTestListener;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            CommandStarting::class,
            CommandStartTestListener::class
        );
    }
}
