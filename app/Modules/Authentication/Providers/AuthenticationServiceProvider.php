<?php

namespace App\Modules\Authentication\Providers;

use App\Modules\Authentication\Actions\Fortify\ResetUserPassword;
use App\Ship\Abstracts\Providers\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Laraneat\Modules\Traits\ModuleProviderHelpersTrait;
use Laravel\Fortify\Fortify;

class AuthenticationServiceProvider extends ServiceProvider
{
    use ModuleProviderHelpersTrait;

    protected string $moduleName = 'Authentication';
    protected string $moduleNameLower = 'authentication';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerMigrations();
        $this->registerCommands();

        $this->setUpServices();
    }

    public function setUpServices(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('laraneat.spa_url', '') . '/reset-password?token=' . $token;
        });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $sourcePath = module_path($this->moduleName, 'Resources/lang');
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        $this->loadTranslationsFrom($sourcePath, $this->moduleNameLower);

        $this->publishes([
            $sourcePath => $langPath,
        ], 'translations');
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $sourcePath = module_path($this->moduleName, 'Config');
        $configPath = config_path();

        $this->loadConfigs($sourcePath);

        $this->publishes([
            $sourcePath => $configPath
        ], 'config');
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $sourcePath = module_path($this->moduleName, 'Resources/views');
        $viewsPath = resource_path('views/modules/' . $this->moduleNameLower);

        $this->loadViewsFrom(
            array_merge($this->getPublishableViewPaths($this->moduleNameLower), [$sourcePath]),
            $this->moduleNameLower
        );

        $this->publishes([
            $sourcePath => $viewsPath
        ], 'views');
    }

    /**
     * Register migrations.
     */
    public function registerMigrations(): void
    {
        $sourcePath = module_path($this->moduleName, 'Data/Migrations');
        $migrationsPath = database_path('migrations');

        $this->loadMigrationsFrom($sourcePath);

        $this->publishes([
            $sourcePath => $migrationsPath
        ], 'migrations');
    }

    /**
     * Register artisan commands.
     */
    public function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->loadCommands(module_path($this->moduleName, 'UI/CLI/Commands'));
        }
    }
}
