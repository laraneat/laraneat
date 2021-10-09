<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @property int[] $role_ids
 */
class SyncUserRolesRequest extends Request
{
    public function rules(): array
    {
        return [
            'role_ids' => 'required|array|min:1',
            'role_ids.*' => [
                'integer',
                Rule::exists(config('permission.table_names.roles'), 'id')
            ]
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['attach-roles']);
    }
}
