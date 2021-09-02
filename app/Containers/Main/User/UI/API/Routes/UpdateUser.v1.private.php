<?php

/**
 * @apiGroup           User
 * @apiName            updateUser
 * @api                {patch} /api/v1/users/:id Update User
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {String}  [password]
 * @apiParam           {String}  [name]
 *
 * @apiUse             UserSuccessSingleResponse
 */

use App\Containers\Main\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::patch('users/{user}', [Controller::class, 'updateUser'])
    ->name('api.users.update')
    ->middleware(['auth:sanctum']);
