<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Requests\DeleteUserRequest;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Http\JsonResponse;

class DeleteUserAction extends Action
{
    public function handle(User $user): bool
    {
        return $user->delete();
    }

    public function asController(DeleteUserRequest $request, User $user): JsonResponse
    {
        $this->handle($user);
        return $this->noContent();
    }
}
