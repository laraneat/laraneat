<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Abstracts\Tasks\Task;
use Exception;

class FindUserByIdTask extends Task
{
    /**
     * @throws NotFoundException
     */
    public function run(int $userId): User
    {
        try {
            $user = User::find($userId);
        } catch (Exception $e) {
            throw new NotFoundException();
        }

        return $user;
    }
}
