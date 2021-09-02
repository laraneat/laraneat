<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class CountRegisteredUsersTask extends Task
{
    public function run(): int
    {
        return User::withEmail()->count();
    }
}
