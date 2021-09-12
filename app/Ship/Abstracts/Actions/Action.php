<?php

namespace App\Ship\Abstracts\Actions;

use Laraneat\Core\Traits\ResponseTrait;
use Lorisleiva\Actions\Concerns\AsAction;

abstract class Action
{
    use asAction;
    use ResponseTrait;
}
