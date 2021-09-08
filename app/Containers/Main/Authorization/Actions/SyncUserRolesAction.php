<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\Tasks\FindRoleTask;
use App\Containers\Main\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tasks\FindUserByIdTask;
use App\Ship\Abstracts\Actions\Action;

class SyncUserRolesAction extends Action
{
    public function run(SyncUserRolesRequest $request): User
    {
        $user = app(FindUserByIdTask::class)->run($request->user_id);

        // convert roles IDs to array (in case single id passed)
        $rolesIds = (array)$request->role_ids;

        $roles = array_map(static function ($roleId) {
            return app(FindRoleTask::class)->run($roleId);
        }, $rolesIds);

        $user->syncRoles($roles);

        return $user;
    }
}
