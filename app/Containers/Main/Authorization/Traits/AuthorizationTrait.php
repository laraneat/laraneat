<?php

namespace App\Containers\Main\Authorization\Traits;

use App\Containers\Main\User\Actions\GetAuthenticatedUserAction;
use Illuminate\Contracts\Auth\Authenticatable;

trait AuthorizationTrait
{
    public function getUser(): ?Authenticatable
    {
        return GetAuthenticatedUserAction::run();
    }

    public function hasAdminRole(): bool
    {
        return $this->hasRole('admin');
    }
}
