<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Ship\Exceptions\DeleteResourceFailedException;
use Exception;
use Illuminate\Http\JsonResponse;
use Spatie\Permission\Models\Role;
use App\Containers\Main\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Ship\Abstracts\Actions\Action;

class DeleteRoleAction extends Action
{
    /**
     * @param Role $role
     *
     * @return bool|null
     * @throws DeleteResourceFailedException
     */
    public function handle(Role $role): ?bool
    {
        try {
            return $role->delete();
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }

    /**
     * @param DeleteRoleRequest $request
     * @param Role $role
     * 
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function asController(DeleteRoleRequest $request, Role $role): JsonResponse
    {
        $this->handle($role);

        return $this->noContent();
    }
}
