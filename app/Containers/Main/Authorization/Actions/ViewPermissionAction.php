<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\UI\API\Requests\ViewPermissionRequest;
use App\Containers\Main\Authorization\UI\API\Resources\PermissionResource;
use App\Ship\Abstracts\Actions\Action;

class ViewPermissionAction extends Action
{
    /**
     * @param ViewPermissionRequest $request
     * 
     * @param Permission $permission
     * @return PermissionResource
     */
    public function handle(ViewPermissionRequest $request, Permission $permission): PermissionResource
    {
        return new PermissionResource($permission);
    }
}
