<?php

namespace App\Ship\Exceptions;

use App\Ship\Parents\Exceptions\Exception;
use Symfony\Component\HttpFoundation\Response;

class DeleteResourceFailedException extends Exception
{
    public function __construct(?string $message = null, ?int $code = Response::HTTP_EXPECTATION_FAILED, ?BaseException $previous = null)
    {
        $message = $message ?? __('exceptions.delete-resource-failed');
        parent::__construct($message, $code, $previous);
    }
}
