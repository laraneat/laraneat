<?php

namespace App\Ship\Abstracts\Providers;

use Laraneat\Core\Abstracts\Providers\BroadcastsProvider as AbstractBroadcastsProvider;
use Illuminate\Support\Facades\Broadcast;

/**
 * A.K.A app/Providers/BroadcastServiceProvider
 */
abstract class BroadcastsProvider extends AbstractBroadcastsProvider
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
