<?php

namespace App\Ship\Parents\Models;

use Laraneat\Core\Abstracts\Models\UserModel as AbstractUserModel;
use Illuminate\Notifications\Notifiable;

abstract class UserModel extends AbstractUserModel
{
    use Notifiable;
}
