<?php

namespace App\Containers\Main\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class RevokeUserFromRoleRequest extends Request
{
    public function rules(): array
    {
        return [
            'role_ids' => 'required',
            'role_ids.*' => 'exists:' . config('permission.table_names.roles') . ',id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['assign-roles']);
    }
}
