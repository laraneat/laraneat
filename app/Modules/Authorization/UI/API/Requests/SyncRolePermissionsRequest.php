<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @property int[] $permission_ids
 */
class SyncRolePermissionsRequest extends Request
{
    public function rules(): array
    {
        return [
            'permission_ids' => 'required|array|min:1',
            'permission_ids.*' => [
                'integer',
                Rule::exists(config('permission.table_names.permissions'), 'id')
            ],
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}
