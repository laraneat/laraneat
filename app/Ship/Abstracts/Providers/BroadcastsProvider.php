<?php

namespace App\Ship\Abstracts\Providers;

use Illuminate\Support\ServiceProvider as LaravelBroadcastServiceProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * A.K.A app/Providers/BroadcastServiceProvider
 */
abstract class BroadcastsProvider extends LaravelBroadcastServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Broadcast::routes();

        require app_path('Ship/Broadcasts/Routes.php');
    }
}
