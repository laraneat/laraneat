<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

class CreateRoleRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|unique:' . config('permission.table_names.roles') . ',name|min:2|max:20|no_spaces',
            'description' => 'string|max:255',
            'display_name' => 'string|max:100',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}