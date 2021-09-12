<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Tasks\DeleteUserTask;
use App\Containers\Main\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\DeleteResourceFailedException;
use Exception;
use Illuminate\Http\JsonResponse;

class DeleteUserAction extends Action
{
    /**
     * @param User $user
     *
     * @return bool
     * @throws DeleteResourceFailedException
     */
    public function handle(User $user): bool
    {
        try {
            return $user->delete();
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }

    /**
     * @param DeleteUserRequest $request
     * @param User $user
     * 
     * @return JsonResponse
     * @throws DeleteResourceFailedException
     */
    public function asController(DeleteUserRequest $request, User $user): JsonResponse
    {
        $this->handle($user);
        return $this->noContent();
    }
}
