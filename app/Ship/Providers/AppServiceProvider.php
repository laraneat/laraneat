<?php

namespace App\Ship\Providers;

use App\Ship\Abstracts\Providers\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Load the ide-helper service provider only in non production environments.
        if ($this->app->isLocal()) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->extendValidationRules();
    }

    /**
     * Extend the default Laravel validation rules.
     */
    public function extendValidationRules(): void
    {
        Validator::extend('no_spaces', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\S*$/u', $value);
        }, 'String should not contain space.');
    }
}
