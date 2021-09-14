<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Permission;
use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Containers\Main\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;
use Exception;
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
     * @throws CreateResourceFailedException
     */
    public function handle(
        string $name,
        ?string $description = null,
        ?string $displayName = null,
        $permissions = null
    ): Role
    {
        try {
            $role = Role::create([
                'name' => strtolower($name),
                'description' => $description,
                'display_name' => $displayName,
                'guard_name' => 'web',
            ]);

            if (!empty($permissions)) {
                AttachPermissionsToRoleAction::make()->handle($role, $permissions);
            }
        } catch (Exception $exception) {
            throw new CreateResourceFailedException();
        }

        return $role;
    }

    /**
     * @param CreateRoleRequest $request
     *
     * @return JsonResponse
     * @throws CreateResourceFailedException
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
