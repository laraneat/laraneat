<?php

namespace App\Modules\Authentication\Actions\Fortify;

use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class ResetUserPassword implements ResetsUserPasswords
{
    /**
     * Validate and reset the user's forgotten password.
     *
     * @param User $user
     * @param array $input
     * @return void
     * @throws ValidationException
     */
    public function reset($user, array $input): void
    {
        Validator::make($input, [
            'password' => ['required', 'confirmed', Password::min(8)],
        ])->validate();

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
