<?php

namespace App\Containers\Main\Authentication\Providers;

use App\Ship\Middlewares\Http\RedirectIfAuthenticated;
use App\Ship\Parents\Providers\MiddlewareProvider;

class MiddlewareServiceProvider extends MiddlewareProvider
{
    protected array $middlewares = [
        // ..
    ];

    protected array $middlewareGroups = [
        'web' => [
            // ..
        ],
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ],
    ];

    protected array $routeMiddleware = [
        // laraneat User Authentication middleware for Web Pages
        'guest' => RedirectIfAuthenticated::class
    ];
}
