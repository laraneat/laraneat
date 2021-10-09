<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\UpdateRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;

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

        $permissionIds = $roleData['permission_ids'] ?? null;
        unset($roleData['permission_ids']);

        $role->update($roleData);

        if ($permissionIds) {
            AttachPermissionsToRoleAction::make()->handle($role, $permissionIds);
        }

        return $role;
    }

    /**
     * @throws UpdateResourceFailedException
     */
    public function asController(UpdateRoleRequest $request, Role $role): RoleResource
    {
        $sanitizedData = $request->sanitizeInput([
            'name',
            'description',
            'display_name',
            'permission_ids'
        ]);

        $role = $this->handle($role, $sanitizedData);

        return new RoleResource($role);
    }
}
