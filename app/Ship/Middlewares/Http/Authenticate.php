<?php

namespace App\Ship\Middlewares\Http;

use App\Ship\Exceptions\AuthenticationException;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;

class Authenticate extends LaravelAuthenticate
{
    /**
     * @throws \Illuminate\Auth\AuthenticationException
     * @throws AuthenticationException
     */
    public function authenticate($request, array $guards): void
    {
        try {
            parent::authenticate($request, $guards);
        } catch (Exception $exception) {
            if ($request->expectsJson()) {
                throw new AuthenticationException();
            } else {
                $this->unauthenticated($request, $guards);
            }
        }
    }

    protected function redirectTo($request): ?string
    {
        return config('authentication.login-page-url');
    }
}
