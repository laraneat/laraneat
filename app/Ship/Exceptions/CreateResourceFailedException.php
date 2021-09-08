<?php

namespace App\Ship\Exceptions;

use App\Ship\Abstracts\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class CreateResourceFailedException extends Exception
{
    public function __construct(
        ?string $message = null,
        ?int $code = Response::HTTP_EXPECTATION_FAILED,
        ?BaseException $previous = null
    )
    {
        parent::__construct(
            $message ?? __('exceptions.create-resource-failed'),
            $code,
            $previous
        );
    }
}
