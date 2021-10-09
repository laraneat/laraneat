<?php

namespace App\Modules\User\UI\API\Requests;

use App\Modules\User\DTO\CreateUserDTO;
use App\Modules\User\Models\User;
use App\Ship\Abstracts\Requests\Request;
use Illuminate\Validation\Rules\Password;

/**
 * @property string $name
 * @property string $email
 * @property string $password
 */
class CreateUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'email' => 'required|email|max:40|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
    }

    public function toDTO(): CreateUserDTO
    {
        return new CreateUserDTO(
            name: $this->name,
            email: $this->email,
            password: $this->password,
        );
    }
}
