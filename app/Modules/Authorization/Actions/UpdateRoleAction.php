<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\UpdateRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateRoleAction extends Action
{
    /**
     * @throws UpdateResourceFailedException
     */
    public function handle(Role $role, array $roleData): Role
    {
        if (empty($roleData)) {
            throw new UpdateResourceFailedException();
        }

        $permissionIds = Arr::pull($roleData, 'permission_ids');

        return DB::transaction(function() use (&$role, $roleData, $permissionIds) {
            $role->update($roleData);

            if ($permissionIds) {
                SyncRolePermissionsAction::make()->handle($role, $permissionIds);
            }

            return $role;
        });
    }

    /**
     * @throws UpdateResourceFailedException
     */
    public function asController(UpdateRoleRequest $request, Role $role): RoleResource
    {
        $role = $this->handle($role, $request->validated());

        return new RoleResource($role);
    }
}
