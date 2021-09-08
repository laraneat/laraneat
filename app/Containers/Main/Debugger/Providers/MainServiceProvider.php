<?php

namespace App\Containers\Main\Debugger\Providers;

use App\Containers\Main\Debugger\Tasks\QueryDebuggerTask;
use App\Ship\Abstracts\Providers\MainProvider;
use Jenssegers\Agent\AgentServiceProvider;
use Jenssegers\Agent\Facades\Agent;

/**
 * Class MainServiceProvider.
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        AgentServiceProvider::class,
        MiddlewareServiceProvider::class
    ];

    /**
     * Container Aliases
     */
    public array $aliases = [
        'Agent' => Agent::class
    ];

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
        parent::register();

        if ($this->app->isLocal()) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        app(QueryDebuggerTask::class)->run();
    }
}
