<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;

class DeleteUserAction extends Action
{
    /**
     * @param User $user
     *
     * @return bool
     */
    public function handle(User $user): bool
    {
        return $user->delete();
    }

    /**
     * @param DeleteUserRequest $request
     * @param User $user
     *
     * @return JsonResponse
     */
    public function asController(DeleteUserRequest $request, User $user): JsonResponse
    {
        $this->handle($user);
        return $this->noContent();
    }
}
