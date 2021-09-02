<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_NOT_FOUND, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.not-found');
        parent::__construct($message, $code, $previous);
    }
}
