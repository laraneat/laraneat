<?php

namespace App\Modules\User\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class UpdateUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'password' => 'min:6|max:40',
            'name' => 'min:2|max:50',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->route('user');
        return $user && optional($this->user())->can('update', $user);
    }
}
