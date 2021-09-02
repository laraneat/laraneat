<?php

/**
 * @apiGroup           RolePermission
 * @apiName            revokeRoleFromUser
 * @api                {post} /api/v1/roles/revoke Revoke/Remove Roles from User
 * @apiDescription     Revoke existing roles from user. This endpoint does not sync the user
 *                     It just revoke the passed role from the user. So make sure
 *                     to never send a non assigned role since it will cause an error.
 *                     To sync (update) all existing roles with the new ones use
 *                     `/roles/sync` endpoint instead.
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiParam           {Number} user_id user ID
 * @apiParam           {Array} role_ids Role ID or Array of Role ID's
 *
 * @apiUse             UserSuccessSingleResponse
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('roles/revoke', [Controller::class, 'revokeRoleFromUser'])
    ->name('api.roles.revoke')
    ->middleware(['auth:sanctum']);
