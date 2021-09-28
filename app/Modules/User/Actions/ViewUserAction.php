<?php

namespace App\Modules\User\Actions;

use App\Modules\User\Models\User;
use App\Modules\User\UI\API\QueryWizards\UserQueryWizard;
use App\Modules\User\UI\API\Requests\ViewUserRequest;
use App\Modules\User\UI\API\Resources\UserResource;
use App\Ship\Abstracts\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class ViewUserAction extends Action
{
    /**
     * @param ViewUserRequest $request
     * @param User $user
     *
     * @return Model
     */
    public function handle(ViewUserRequest $request, User $user): Model
    {
        return UserQueryWizard::for($user, $request)->build();
    }

    /**
     * @param ViewUserRequest $request
     * @param User $user
     *
     * @return UserResource
     */
    public function asController(ViewUserRequest $request, User $user): UserResource
    {
        return new UserResource($this->handle($request, $user));
    }
}
