<?php

namespace App\Containers\Main\Authorization\Tasks;

use App\Containers\Main\Authorization\Models\Role;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

class DeleteRoleTask extends Task
{
    public function run(Role $role): ?bool
    {
        try {
            return $role->delete();
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
