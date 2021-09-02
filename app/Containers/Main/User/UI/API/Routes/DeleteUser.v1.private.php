<?php

/**
 * @apiGroup           User
 * @apiName            deleteUser
 * @api                {delete} /api/v1/users/:id Delete User
 * @apiDescription     Delete users of any type (Admin, Client...)
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 OK
 * {
 * "message": "User (4) Deleted Successfully."
 * }
 */

use App\Containers\Main\User\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('users/{user}', [Controller::class, 'deleteUser'])
    ->name('api.users.delete')
    ->middleware(['auth:sanctum']);
