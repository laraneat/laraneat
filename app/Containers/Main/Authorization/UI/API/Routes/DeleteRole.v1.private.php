<?php

/**
 * @apiGroup           RolePermission
 * @apiName            deleteRole
 * @api                {delete} /api/v1/roles/:id Delete a Role
 * @apiDescription     Delete Role by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Role
 *
 * @apiSuccessExample  {json}       Success-Response:
 * HTTP/1.1 202 OK
 * {
 * "message": "Role (manager) Deleted Successfully."
 * }
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('roles/{role}', [Controller::class, 'deleteRole'])
    ->name('api.roles.delete')
    ->middleware(['auth:sanctum']);
