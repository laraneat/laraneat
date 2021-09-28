<?php

namespace App\Modules\Authorization\Traits;

use App\Modules\User\Actions\GetAuthenticatedUserAction;
use Illuminate\Contracts\Auth\Authenticatable;

trait AuthorizationTrait
{
    public function getUser(): ?Authenticatable
    {
        return GetAuthenticatedUserAction::make()->handle();
    }

    public function hasAdminRole(): bool
    {
        return $this->hasRole('admin');
    }
}
