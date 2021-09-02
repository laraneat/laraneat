<?php

namespace App\Containers\Main\User\UI\API\Requests;

use App\Containers\Main\User\Models\User;
use App\Ship\Parents\Requests\Request;

class RegisterUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:40|unique:users,email',
            'password' => 'required|min:6|max:30',
            'name' => 'required|min:2|max:50',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }
}
