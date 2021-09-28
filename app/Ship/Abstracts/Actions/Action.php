<?php

namespace App\Ship\Abstracts\Actions;

use Laraneat\Modules\Traits\ResponseHelpersTrait;
use Lorisleiva\Actions\Concerns\AsAction;

abstract class Action
{
    use asAction, ResponseHelpersTrait;
}
