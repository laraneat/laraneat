<?php

namespace App\Containers\Main\User\UI\API\Requests;

use App\Containers\Main\User\Models\User;
use App\Ship\Abstracts\Requests\Request;

class ListUsersRequest extends Request
{
    protected function defaultTable(): string
    {
        return 'users';
    }

    protected function allowedFields(): array
    {
        return [
            'id',
            'users.name',
        ];
    }

    public function rules(): array
    {
        return [
            'filters' => 'nullable|array',
            'filters.age' => 'integer',
            'fields' => 'nullable|array',
            'fields.*' => '',
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('viewAny', User::class);
    }
}
