<?php

/**
 * @apiGroup           User
 * @apiName            listUsers
 * @api                {get} /api/v1/users Get All Users
 * @apiDescription     Get All Application Users.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

use App\Containers\Main\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('users', [Controller::class, 'listUsers'])
    ->name('api.users.list')
    ->middleware(['auth:sanctum']);
