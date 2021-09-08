<?php

namespace App\Ship\Exceptions;

use App\Ship\Abstracts\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class InternalErrorException extends Exception
{
    public function __construct(
        ?string $message = null,
        ?int $code = Response::HTTP_INTERNAL_SERVER_ERROR,
        ?BaseException $previous = null
    ) {
        parent::__construct(
            $message ?? __('exceptions.internal-error'),
            $code,
            $previous
        );
    }
}
