<?php

namespace App\Containers\Main\User\UI\API\Requests;

use App\Containers\Main\User\Models\User;
use App\Ship\Abstracts\Requests\Request;

class ListUsersRequest extends Request
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return $this->user()->can('viewAny', User::class);
    }
}
