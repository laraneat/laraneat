<?php

/**
 * @apiGroup           User
 * @apiName            viewUser
 * @api                {get} /api/v1/users/:id View User
 * @apiDescription     Get user data by id
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             UserSuccessSingleResponse
 */

use App\Containers\Main\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('users/{user}', [Controller::class, 'viewUser'])
    ->name('api.users.view')
    ->middleware(['auth:sanctum']);
