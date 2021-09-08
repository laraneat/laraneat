<?php

namespace App\Containers\Main\User\Tasks;

use App\Containers\Main\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Abstracts\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Hash;

class CreateUserByCredentialsTask extends Task
{
    public function run(
        string $email,
        string $password,
        string $name = null
    ): User
    {
        try {
            // create new user
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
}
