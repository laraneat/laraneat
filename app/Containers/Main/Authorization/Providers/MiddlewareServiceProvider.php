<?php

namespace App\Containers\Main\Authorization\Providers;

use App\Ship\Abstracts\Providers\MiddlewareProvider;
use Illuminate\Auth\Middleware\Authorize;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    protected array $middlewares = [
        // ..
    ];

    protected array $middlewareGroups = [
        'web' => [

        ],
        'api' => [

        ],
    ];

    protected array $routeMiddleware = [
        // Laravel default route middleware's:
        'can' => Authorize::class,
    ];
}
