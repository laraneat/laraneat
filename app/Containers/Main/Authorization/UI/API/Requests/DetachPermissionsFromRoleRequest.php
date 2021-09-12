<?php

namespace App\Containers\Main\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class DetachPermissionsFromRoleRequest extends Request
{
    public function rules(): array
    {
        return [
            'permissions_ids' => 'required|array',
            'permissions_ids.*' => 'exists:' . config('permission.table_names.permissions') . ',id',
            'role_id' => 'required|exists:' . config('permission.table_names.roles') . ',id',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}
