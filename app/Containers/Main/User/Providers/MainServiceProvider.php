<?php

namespace App\Containers\Main\User\Providers;

use App\Ship\Parents\Providers\MainProvider;

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
        // InternalServiceProviderExample::class,
        // ...
    ];

    /**
     * Container Aliases
     */
    public array $aliases = [

    ];

    /**
     * Register anything in the container.
     */
    public function register(): void
    {
        parent::register();

        // do your binding here..
        // $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
