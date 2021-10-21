<?php

namespace App\Modules\Authorization\UI\API\Requests;

use App\Modules\Authorization\DTO\CreateRoleDTO;
use App\Ship\Abstracts\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property string|null $description
 * @property string|null $display_name
 * @property int[]|null $permission_ids
 */
class CreateRoleRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:' . config('permission.table_names.roles') . ',name|min:2|max:20|no_spaces',
            'description' => 'string|max:255|nullable',
            'display_name' => 'string|max:100|nullable',
            'permission_ids' => 'array|nullable',
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

    public function toDTO(): CreateRoleDTO
    {
        return new CreateRoleDTO(
            name: $this->name,
            description: $this->description,
            display_name: $this->display_name,
            permissions: $this->permission_ids
        );
    }
}
