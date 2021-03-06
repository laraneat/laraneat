<?php

namespace App\Modules\User\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class GetAuthenticatedUserRequest extends Request
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        return $this->user()->can('view', $this->user());
    }
}
