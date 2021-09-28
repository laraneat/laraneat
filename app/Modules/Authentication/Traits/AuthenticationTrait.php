<?php

namespace App\Modules\Authentication\Traits;
use Laravel\Sanctum\HasApiTokens;

trait AuthenticationTrait
{
    use HasApiTokens;
}
