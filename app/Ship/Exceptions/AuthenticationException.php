<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_UNAUTHORIZED, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.authentication');
        parent::__construct($message, $code, $previous);
    }
}
