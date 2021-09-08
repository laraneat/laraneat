<?php

namespace App\Ship\Exceptions;

use App\Ship\Abstracts\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    public function __construct(
        ?string $message = null,
        ?int $code = Response::HTTP_NOT_FOUND,
        ?BaseException $previous = null
    ) {
        parent::__construct(
            $message ?? __('exceptions.not-found'),
            $code,
            $previous
        );
    }
}
