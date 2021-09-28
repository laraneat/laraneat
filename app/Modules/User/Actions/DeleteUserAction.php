<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Requests\DeleteUserRequest;
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
