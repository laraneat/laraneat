<?php

namespace App\Modules\Authorization\DTO;

use App\Modules\Authorization\Models\Permission;
use App\Ship\Abstracts\DTO\DataTransferObject;
use Illuminate\Support\Collection;
use Spatie\DataTransferObject\Attributes\Strict;

#[Strict]
class CreateRoleDTO extends DataTransferObject
{
    public string $name;
    public ?string $description;
    public ?string $displayName;
    public string $guardName = 'web';
    public null|int|string|array|Collection|Permission $permissions;
}
