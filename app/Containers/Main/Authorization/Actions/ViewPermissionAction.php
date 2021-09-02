<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\UI\API\Requests\ViewPermissionRequest;
use App\Ship\Parents\Actions\Action;

class ViewPermissionAction extends Action
{
    public function run(ViewPermissionRequest $request, Permission $permission): Permission
    {
        return $permission;
    }
}
