<?php

namespace App\Ship\Abstracts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as LaravelAuthenticatableUser;
use Illuminate\Notifications\Notifiable;
use Laraneat\Core\Traits\FactoryLocatorTrait;
use Spatie\Permission\Traits\HasRoles;

abstract class UserModel extends LaravelAuthenticatableUser
{
    use Notifiable;
    use HasRoles;
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }
}
