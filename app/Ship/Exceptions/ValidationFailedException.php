<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class ValidationFailedException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_UNPROCESSABLE_ENTITY, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.validation-failed');
        parent::__construct($message, $code, $previous);
    }
}
