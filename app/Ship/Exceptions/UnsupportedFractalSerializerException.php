<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class UnsupportedFractalSerializerException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_INTERNAL_SERVER_ERROR, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.unsupported-fractal-serializer');
        parent::__construct($message, $code, $previous);
    }
}
