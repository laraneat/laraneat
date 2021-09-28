<?php

namespace App\Modules\User\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class DeleteUserRequest extends Request
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        $user = $this->route('user');
        return $user && $this->user()->can('delete', $user);
    }
}
