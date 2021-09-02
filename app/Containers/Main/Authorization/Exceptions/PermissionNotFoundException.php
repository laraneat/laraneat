<?php

namespace App\Containers\Main\Authorization\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class PermissionNotFoundException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_NOT_FOUND, ?BaseException $previous = null)
    {
        $message = $message ?? __('Main@authorization::exceptions.permission-not-found');
        parent::__construct($message, $code, $previous);
    }
}
