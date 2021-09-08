<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Tasks\AssignUserToRoleTask;
use App\Containers\Main\Authorization\Tasks\FindRoleTask;
use App\Containers\Main\Authorization\UI\API\Requests\AssignUserToRoleRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tasks\FindUserByIdTask;
use App\Ship\Abstracts\Actions\Action;

class AssignUserToRoleAction extends Action
{
    public function run(AssignUserToRoleRequest $request): User
    {
        $user = app(FindUserByIdTask::class)->run($request->user_id);

        // convert to array in case single ID was passed
        $rolesIds = (array)$request->role_ids;

        $roles = array_map(static function ($roleId) {
            return app(FindRoleTask::class)->run($roleId);
        }, $rolesIds);

        return app(AssignUserToRoleTask::class)->run($user, $roles);
    }
}
