<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tasks\DeleteUserTask;
use App\Containers\Main\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Abstracts\Actions\Action;

class DeleteUserAction extends Action
{
    public function run(DeleteUserRequest $request, User $user): void
    {
        app(DeleteUserTask::class)->run($user);
    }
}
