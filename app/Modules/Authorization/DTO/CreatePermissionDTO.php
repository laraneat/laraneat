<?php

namespace App\Modules\Authorization\DTO;

use App\Ship\Abstracts\DTO\DataTransferObject;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
class CreatePermissionDTO extends DataTransferObject
{
    public string $name;
    public ?string $display_name;
    public ?string $group;
    public ?string $description;
    public string $guard_name = 'web';
}
