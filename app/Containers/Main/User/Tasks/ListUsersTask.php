<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Parents\Tasks\Task;

class ListUsersTask extends Task
{
    public function run(bool $paginated = true)
    {
        return $paginated ? User::paginate() : User::all();
    }
}
