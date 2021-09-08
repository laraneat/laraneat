<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Abstracts\Tasks\Task;
use Exception;

class FindUserByEmailTask extends Task
{
    public function run(string $email): User
    {
        try {
            return User::where('email', $email)->first();
        } catch (Exception $e) {
            throw new NotFoundException();
        }
    }
}
