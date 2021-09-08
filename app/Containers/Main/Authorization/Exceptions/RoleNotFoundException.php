<?php

namespace App\Containers\Main\Authorization\Exceptions;

use App\Ship\Abstracts\Exceptions\Exception;
use Exception as BaseException;
use Symfony\Component\HttpFoundation\Response;

class RoleNotFoundException extends Exception
{
    public function __construct(
        ?string $message = null,
        ?int $code = Response::HTTP_NOT_FOUND,
        ?BaseException $previous = null
    ) {
        parent::__construct(
            $message ?? __('main@authorization::exceptions.role-not-found'),
            $code,
            $previous
        );
    }
}
