<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Tasks\Task;

class CreatePasswordResetTask extends Task
{
    public function run(User $user): string
    {
        try {
            return app('auth.password.broker')->createToken($user);
        } catch (Exception $e) {
            throw new InternalErrorException();
        }
    }
}
