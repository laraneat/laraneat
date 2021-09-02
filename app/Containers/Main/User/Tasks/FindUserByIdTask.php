<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class FindUserByIdTask extends Task
{
    public function run($userId): User
    {
        try {
            $user = User::find($userId);
        } catch (Exception $e) {
            throw new NotFoundException();
        }

        return $user;
    }
}
