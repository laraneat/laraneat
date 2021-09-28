<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Permission;
use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;

class CreateRoleAction extends Action
{
    /**
     * @param string $name
     * @param string|null $description
     * @param string|null $displayName
     * @param null|int|string|Permission|array|\Illuminate\Support\Collection $permissions
     *
     * @return Role
     */
    public function handle(
        string $name,
        ?string $description = null,
        ?string $displayName = null,
        $permissions = null
    ): Role
    {
        $role = Role::create([
            'name' => strtolower($name),
            'description' => $description,
            'display_name' => $displayName,
            'guard_name' => 'web',
        ]);

        if (!empty($permissions)) {
            AttachPermissionsToRoleAction::make()->handle($role, $permissions);
        }

        return $role;
    }

    /**
     * @param CreateRoleRequest $request
     *
     * @return JsonResponse
     */
    public function asController(CreateRoleRequest $request): JsonResponse
    {
        $role = $this->handle(
            name: $request->name,
            description: $request->description,
            displayName: $request->display_name
        );

        return (new RoleResource($role))->created();
    }
}
