<?php

namespace App\Containers\Main\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class AttachRolesToUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:' . config('permission.table_names.roles') . ',id',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['attach-roles']);
    }
}
