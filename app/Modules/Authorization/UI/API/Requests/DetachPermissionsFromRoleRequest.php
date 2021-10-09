<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

/**
 * @property int[] $permission_ids
 */
class DetachPermissionsFromRoleRequest extends Request
{
    public function rules(): array
    {
        return [
            'permission_ids' => 'required|array|min:1',
            'permission_ids.*' => 'integer|exists:' . config('permission.table_names.permissions') . ',id',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}
