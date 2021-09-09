<?php

namespace App\Containers\Main\Authorization\Actions;

use App\Containers\Main\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tasks\FindUserByIdTask;
use App\Ship\Abstracts\Actions\Action;

class RevokeUserFromRoleAction extends Action
{
    public function run(RevokeUserFromRoleRequest $request): User
    {
        $user = null;

        // if user ID is passed then convert it to instance of User (could be user Id Or Model)
        if (!$request->user_id instanceof User) {
            $user = app(FindUserByIdTask::class)->run($request->user_id);
        }

        // convert to array in case single ID was passed (could be Single Or Multiple Role Ids)
        $rolesIds = (array)$request->role_ids;

        $user->roles()->detach($rolesIds);

        return $user;
    }
}
