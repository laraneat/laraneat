<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\UI\API\QueryWizards\PermissionQueryWizard;
use App\Modules\Authorization\UI\API\Requests\ViewPermissionRequest;
use App\Modules\Authorization\UI\API\Resources\PermissionResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ViewPermissionAction extends Action
{
    public function handle(ViewPermissionRequest $request, Permission $permission): Model
    {
        return PermissionQueryWizard::for($permission, $request)->build();
    }

    public function asController(ViewPermissionRequest $request, Permission $permission): PermissionResource
    {
        return new PermissionResource($this->handle($request, $permission));
    }
}
