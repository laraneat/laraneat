<?php

namespace App\Ship\Abstracts\Requests;

use Laraneat\Modules\Traits\SanitizerTrait;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

abstract class Request extends LaravelFormRequest
{
    use SanitizerTrait;
}
