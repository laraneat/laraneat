<?php

namespace App\Modules\User\DTO;

use App\Ship\Abstracts\DTO\DataTransferObject;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
class CreateUserDTO extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $password;
}
