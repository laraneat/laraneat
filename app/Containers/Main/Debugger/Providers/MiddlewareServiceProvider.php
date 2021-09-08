<?php

namespace App\Containers\Main\Debugger\Providers;

use App\Containers\Main\Debugger\Middlewares\RequestsMonitorMiddleware;
use App\Ship\Abstracts\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * Register Middlewares
     *
     * @var  array
     */
    protected array $middlewares = [
        RequestsMonitorMiddleware::class,
    ];

    /**
     * Register Container Middleware Groups
     *
     * @var  array
     */
    protected array $middlewareGroups = [
        'web' => [],
        'api' => [],
    ];

    /**
     * Register Route Middlewares
     *
     * @var  array
     */
    protected array $routeMiddleware = [];
}
