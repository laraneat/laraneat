<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class NotImplementedException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_NOT_IMPLEMENTED, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.not-implemented');
        parent::__construct($message, $code, $previous);
    }
}
