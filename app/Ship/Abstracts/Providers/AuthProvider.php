<?php

namespace App\Ship\Abstracts\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as LaravelAuthServiceProvider;

/**
 * A.K.A app/Providers/AuthServiceProvider
 */
abstract class AuthProvider extends LaravelAuthServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
