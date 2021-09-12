<?php

namespace App\Containers\Main\User\Actions;

use App\Containers\Main\User\Events\UserRegisteredEvent;
use App\Containers\Main\User\Mails\UserRegisteredMail;
use App\Containers\Main\User\Models\User;
use App\Containers\Main\User\Notifications\UserRegisteredNotification;
use App\Containers\Main\User\UI\API\Requests\CreateUserRequest;
use App\Containers\Main\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use App\Ship\Exceptions\CreateResourceFailedException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CreateUserAction extends Action
{
    /**
     * @param string $email
     * @param string $password
     * @param string|null $name
     *
     * @return User
     * @throws CreateResourceFailedException
     */
    public function handle(
        string $email,
        string $password,
        string $name = null
    ): User
    {
        try {
            $user = User::create([
                'password' => Hash::make($password),
                'email' => $email,
                'name' => $name,
            ]);
        } catch (Exception $e) {
            throw new CreateResourceFailedException();
        }

        return $user;
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return JsonResponse
     * @throws CreateResourceFailedException
     */
    public function asController(CreateUserRequest $request): JsonResponse
    {
        $user = $this->handle(
            $request->email,
            $request->password,
            $request->name,
        );

        Mail::send(new UserRegisteredMail($user));
        Notification::send($user, new UserRegisteredNotification($user));

        dispatch(new UserRegisteredEvent($user));

        return (new UserResource($user))->created();
    }
}
