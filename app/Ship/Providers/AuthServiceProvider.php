<?php

namespace App\Ship\Providers;

use App\Ship\Abstracts\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Modules\SomeModule\Models\Model' => 'App\Modules\SomeModule\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::guessPolicyNamesUsing(function ($class) {
            return str_replace("\\Models\\", "\\Policies\\" , $class) . 'Policy';
        });
    }
}
