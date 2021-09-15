<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\QueryWizards\RoleQueryWizard;
use App\Containers\Main\Authorization\UI\API\Requests\ViewRoleRequest;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ViewRoleAction extends Action
{
    /**
     * @param ViewRoleRequest $request
     * @param Role $role
     *
     * @return Model
     */
    public function handle(ViewRoleRequest $request, Role $role): Model
    {
        return RoleQueryWizard::for($role, $request)->build();
    }

    /**
     * @param ViewRoleRequest $request
     * @param Role $role
     *
     * @return RoleResource
     */
    public function asController(ViewRoleRequest $request, Role $role): RoleResource
    {
        return new RoleResource($this->handle($request, $role));
    }
}
