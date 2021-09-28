<?php

namespace App\Modules\User\UI\API\Requests;

use App\Modules\User\Models\User;
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
