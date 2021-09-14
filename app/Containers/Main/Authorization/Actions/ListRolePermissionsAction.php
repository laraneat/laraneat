<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\QueryWizards\PermissionsQueryWizard;
use App\Containers\Main\Authorization\UI\API\Requests\ListPermissionsRequest;
use App\Containers\Main\Authorization\UI\API\Resources\PermissionResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

class ListRolePermissionsAction extends Action
{
    /**
     * @param ListPermissionsRequest $request
     * @param Role $role
     *
     * @return AbstractPaginator
     */
    public function handle(ListPermissionsRequest $request, Role $role): AbstractPaginator
    {
        return PermissionsQueryWizard::for($role->permissions(), $request)
            ->build()
            ->jsonPaginate();
    }

    /**
     * @param ListPermissionsRequest $request
     * @param Role $role
     *
     * @return ResourceCollection
     */
    public function asController(ListPermissionsRequest $request, Role $role): ResourceCollection
    {
        return PermissionResource::collection($this->handle($request, $role));
    }
}
