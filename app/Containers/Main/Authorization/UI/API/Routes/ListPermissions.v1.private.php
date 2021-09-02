<?php

/**
 * @apiGroup           RolePermission
 * @apiName            listPermissions
 * @api                {get} /api/v1/permissions Get All Permission
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             GeneralSuccessMultipleResponse
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('permissions', [Controller::class, 'listPermissions'])
    ->name('api.permissions.list')
    ->middleware(['auth:sanctum']);
