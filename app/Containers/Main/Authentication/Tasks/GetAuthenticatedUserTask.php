<?php

namespace App\Containers\Main\Authentication\Tasks;

use App\Ship\Abstracts\Tasks\Task;
use App\Containers\Main\User\Models\User;
use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUserTask extends Task
{
    public function run(): ?User
    {
        return Auth::user();
    }
}
