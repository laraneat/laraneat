<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class EmailIsMissedException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_INTERNAL_SERVER_ERROR, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.email-is-missed');
        parent::__construct($message, $code, $previous);
    }
}
