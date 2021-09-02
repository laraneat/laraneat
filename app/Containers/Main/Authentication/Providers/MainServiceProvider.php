<?php

namespace App\Containers\Main\Authentication\Providers;

use App\Ship\Parents\Providers\MainProvider;

/**
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        FortifyServiceProvider::class,
        AuthProvider::class,
        MiddlewareServiceProvider::class
    ];

    /**
     * Container Aliases
     */
    public array $aliases = [
        // 'Foo' => Bar::class,
    ];
}
