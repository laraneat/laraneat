<?php

namespace App\Modules\Authorization\Providers;

use App\Ship\Abstracts\Providers\ServiceProvider;
use Laraneat\Modules\Traits\ModuleProviderHelpersTrait;

class AuthorizationServiceProvider extends ServiceProvider
{
    use ModuleProviderHelpersTrait;

    protected string $moduleName = 'Authorization';
    protected string $moduleNameLower = 'authorization';

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
