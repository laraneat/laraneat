<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @property string|null $name
 * @property string|null $description
 * @property string|null $display_name
 * @property int[]|null $permission_ids
 */
class UpdateRoleRequest extends Request
{
    public function rules(): array
    {
        $role = $this->route('role');

        return [
            'name' => [
                'string',
                'min:2',
                'max:20',
                'no_spaces',
                Rule::unique(config('permission.table_names.roles'))->ignore($role->name),
            ],
            'description' => 'string|max:255',
            'display_name' => 'string|max:100',
            'permission_ids' => 'array|nullable',
            'permission_ids.*' => [
                'integer',
                Rule::exists(config('permission.table_names.permissions'), 'id')
            ],
        ];
    }

    public function authorize(): bool
    {
        $role = $this->route('role');
        return $role && $this->user()?->can('update', $role);
    }
}
