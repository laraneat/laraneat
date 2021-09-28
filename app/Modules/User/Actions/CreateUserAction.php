<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Events\UserRegisteredEvent;
use App\Modules\User\Mails\UserRegisteredMail;
use App\Modules\User\Models\User;
use App\Modules\User\Notifications\UserRegisteredNotification;
use App\Modules\User\UI\API\Requests\CreateUserRequest;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
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
     */
    public function handle(
        string $email,
        string $password,
        string $name = null
    ): User
    {
        return User::create([
            'password' => Hash::make($password),
            'email' => $email,
            'name' => $name,
        ]);
    }

    /**
     * @param CreateUserRequest $request
     *
     * @return JsonResponse
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
