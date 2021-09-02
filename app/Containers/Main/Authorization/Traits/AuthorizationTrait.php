<?php

namespace App\Containers\Main\Authorization\Traits;

use App\Containers\Main\Authentication\Tasks\GetAuthenticatedUserTask;
use Illuminate\Contracts\Auth\Authenticatable;

trait AuthorizationTrait
{
    public function getUser(): ?Authenticatable
    {
        return app(GetAuthenticatedUserTask::class)->run();
    }

    public function hasAdminRole(): bool
    {
        return $this->hasRole('admin');
    }
}
