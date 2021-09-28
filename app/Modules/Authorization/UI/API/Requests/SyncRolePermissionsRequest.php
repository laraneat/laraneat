<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class SyncRolePermissionsRequest extends Request
{
    public function rules(): array
    {
        return [
            'permissions_ids' => 'required|array',
            'permissions_ids.*' => 'exists:' . config('permission.table_names.permissions') . ',id',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}
