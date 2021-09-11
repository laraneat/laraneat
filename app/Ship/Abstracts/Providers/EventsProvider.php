<?php

namespace App\Ship\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as LaravelEventServiceProvider;

/**
 * A.K.A app/Providers/EventServiceProvider
 */
abstract class EventsProvider extends LaravelEventServiceProvider
{
    /**
     * Register any other events for your application.
     */
    public function boot(): void
    {
        parent::boot();
    }
}
