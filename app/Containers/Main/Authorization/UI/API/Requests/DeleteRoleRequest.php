<?php

namespace App\Containers\Main\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class DeleteRoleRequest extends Request
{
    public function rules(): array
    {
        return [];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}
