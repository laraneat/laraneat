<?php

/**
 * @apiGroup           RolePermission
 * @apiName            listRoles
 * @api                {get} /api/v1/roles Get All Roles
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('roles', [Controller::class, 'listRoles'])
    ->name('api.roles.list')
    ->middleware(['auth:sanctum']);
