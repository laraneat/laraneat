<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\GetAuthenticatedUserRequest;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Abstracts\Actions\Action;

class GetAuthenticatedUserAction extends Action
{
    /**
     * @throws NotFoundException
     */
    public function run(GetAuthenticatedUserRequest $request): User
    {
        $user = app(GetAuthenticatedUserTask::class)->run();

        if (!$user) {
            throw new NotFoundException();
        }

        return $user;
    }
}
