<?php

namespace App\Containers\Main\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class ViewUserRequest extends Request
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        $user = $this->route('user');
        return $user && $this->user()->can('view', $user);
    }
}
