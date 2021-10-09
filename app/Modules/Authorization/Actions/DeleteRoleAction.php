<?php

namespace App\Modules\Authorization\Actions;

use App\Modules\Authorization\Models\Role;
use App\Modules\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;

class DeleteRoleAction extends Action
{
    public function handle(Role $role): ?bool
    {
        return $role->delete();
    }

    public function asController(DeleteRoleRequest $request, Role $role): JsonResponse
    {
        $this->handle($role);

        return $this->noContent();
    }
}
