<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\Authentication\Tasks\GetAuthenticatedUserTask;
use App\Containers\Main\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Abstracts\Actions\Action;

class GetAuthenticatedUserAction extends Action
{
    public function run(): User
    {
        $user = app(GetAuthenticatedUserTask::class)->run();

        if (!$user) {
            throw new NotFoundException();
        }

        return $user;
    }
}
