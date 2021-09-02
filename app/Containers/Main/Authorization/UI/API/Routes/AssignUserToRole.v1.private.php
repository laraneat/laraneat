<?php

/**
 * @apiGroup           RolePermission
 * @apiName            assignUserToRole
 * @api                {post} /api/v1/roles/assign Assign User to Roles
 * @apiDescription     Assign new roles to user. This endpoint does not sync the user with the
 *                     new roles. It simply assign new role to the user. So make sure
 *                     to never send an already assigned role since it will cause an error.
 *                     To sync (update) all existing roles with the new ones use
 *                     `/roles/sync` endpoint instead.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Number} user_id User ID
 * @apiParam           {Array} role_ids Role ID or Array of Roles ID's
 *
 * @apiUse             UserSuccessSingleResponse
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('roles/assign', [Controller::class, 'assignUserToRole'])
    ->name('api.roles.assign')
    ->middleware(['auth:sanctum']);
