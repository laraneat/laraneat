<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Abstracts\Tasks\Task;

class CountUsersTask extends Task
{
    public function run(): int
    {
        return User::count();
    }
}
