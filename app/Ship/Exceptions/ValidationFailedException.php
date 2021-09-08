<?php

namespace App\Ship\Exceptions;

use App\Ship\Abstracts\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class ValidationFailedException extends Exception
{
    public function __construct(
        ?string $message = null,
        ?int $code = Response::HTTP_UNPROCESSABLE_ENTITY,
        ?BaseException $previous = null
    ) {
        parent::__construct(
            $message ?? __('exceptions.validation-failed'),
            $code,
            $previous
        );
    }
}
