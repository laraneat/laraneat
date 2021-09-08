<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\ViewRoleRequest;
use App\Ship\Abstracts\Actions\Action;

class ViewRoleAction extends Action
{
    public function run(ViewRoleRequest $request, Role $role): Role
    {
        return $role;
    }
}
