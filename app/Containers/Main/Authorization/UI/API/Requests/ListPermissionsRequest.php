<?php

namespace App\Containers\Main\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class ListPermissionsRequest extends Request
{
    public function rules(): array
    {
        return [
            'filter' => 'array',
            'filter.name' => 'string',
            'filter.guard_name' => 'string',
            'filter.group' => 'string',
            'filter.display_name' => 'string',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->user();
        return $user && $user->hasAnyPermission(['manage-roles']);
    }
}
