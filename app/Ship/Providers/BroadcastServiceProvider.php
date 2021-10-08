<?php

namespace App\Ship\Providers;

use App\Ship\Abstracts\Providers\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Broadcast::routes();

        require app_path('Ship/Broadcasts/routes.php');
    }
}
