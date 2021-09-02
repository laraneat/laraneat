<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class MissingJSONHeaderException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_BAD_REQUEST, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.not-authorized');
        parent::__construct($message, $code, $previous);
    }
}
