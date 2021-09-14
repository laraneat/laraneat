<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\UI\API\QueryWizards\PermissionModelWizard;
use App\Containers\Main\Authorization\UI\API\Requests\ViewPermissionRequest;
use App\Containers\Main\Authorization\UI\API\Resources\PermissionResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ViewPermissionAction extends Action
{
    /**
     * @param ViewPermissionRequest $request
     * @param Permission $permission
     *
     * @return Model
     */
    public function handle(ViewPermissionRequest $request, Permission $permission): Model
    {
        return PermissionModelWizard::for($permission, $request)->build();
    }

    /**
     * @param ViewPermissionRequest $request
     * @param Permission $permission
     *
     * @return PermissionResource
     */
    public function asController(ViewPermissionRequest $request, Permission $permission): PermissionResource
    {
        return new PermissionResource($this->handle($request, $permission));
    }
}
