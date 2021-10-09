<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use App\Modules\User\UI\API\Requests\UpdateUserRequest;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\UpdateResourceFailedException;
use Illuminate\Support\Facades\Hash;

class UpdateUserAction extends Action
{
    /**
     * @throws UpdateResourceFailedException
     */
    public function handle(User $user, array $userData): User
    {
        if (empty($userData)) {
            throw new UpdateResourceFailedException();
        }

        if (array_key_exists('password', $userData)) {
            $userData['password'] = Hash::make($userData['password']);
        }

        $user->update($userData);

        return $user;
    }

    public function asController(UpdateUserRequest $request, User $user): UserResource
    {
        $sanitizedData = $request->sanitizeInput([
            'password',
            'name',
        ]);

        $user = $this->handle($user, $sanitizedData);

        return new UserResource($user);
    }
}
