<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;

class DeleteRoleAction extends Action
{
    /**
     * @param Role $role
     *
     * @return bool|null
     */
    public function handle(Role $role): ?bool
    {
        return $role->delete();
    }

    /**
     * @param DeleteRoleRequest $request
     * @param Role $role
     *
     * @return JsonResponse
     */
    public function asController(DeleteRoleRequest $request, Role $role): JsonResponse
    {
        $this->handle($role);

        return $this->noContent();
    }
}
