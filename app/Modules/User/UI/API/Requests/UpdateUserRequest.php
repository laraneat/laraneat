<?php

namespace App\Modules\User\UI\API\Requests;

use App\Ship\Abstracts\Requests\Request;

/**
 * @property string|null $name
 */
class UpdateUserRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => 'string|min:2|max:50',
        ];
    }

    public function authorize(): bool
    {
        $user = $this->route('user');
        return $user && $this->user()?->can('update', $user);
    }
}
