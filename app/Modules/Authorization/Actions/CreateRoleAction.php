<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\DTO\CreateRoleDTO;
use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Modules\Authorization\UI\API\Resources\RoleResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CreateRoleAction extends Action
{
    /**
     * @throws \Throwable
     */
    public function handle(CreateRoleDTO $dto): Role
    {
        return DB::transaction(function() use ($dto) {
            $role = Role::create([
                'name' => strtolower($dto->name),
                'description' => $dto->description,
                'display_name' => $dto->displayName,
                'guard_name' => $dto->guardName,
            ]);

            if (!empty($dto->permissions)) {
                $role = AttachPermissionsToRoleAction::make()->handle($role, $dto->permissions);
            }

            return $role;
        });
    }

    /**
     * @throws \Throwable
     */
    public function asController(CreateRoleRequest $request): JsonResponse
    {
        $role = $this->handle($request->toDTO());

        return (new RoleResource($role))->created();
    }
}
