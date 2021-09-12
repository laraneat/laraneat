<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\ViewRoleRequest;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;

class ViewRoleAction extends Action
{
    /**
     * @param ViewRoleRequest $request
     * 
     * @param Role $role
     * @return RoleResource
     */
    public function handle(ViewRoleRequest $request, Role $role): RoleResource
    {
        return new RoleResource($role);
    }
}
