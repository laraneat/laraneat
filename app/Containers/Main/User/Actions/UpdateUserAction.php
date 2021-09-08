<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tasks\UpdateUserTask;
use App\Containers\Main\User\UI\API\Requests\UpdateUserRequest;
use App\Ship\Abstracts\Actions\Action;

class UpdateUserAction extends Action
{
    public function run(UpdateUserRequest $request, User $user): User
    {
        $sanitizedData = $request->sanitizeInput([
            'password',
            'name',
        ]);

        return app(UpdateUserTask::class)->run($sanitizedData, $user);
    }
}
