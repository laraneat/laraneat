<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Abstracts\Tasks\Task;

class CountRegisteredUsersTask extends Task
{
    public function run(): int
    {
        return User::withEmail()->count();
    }
}
