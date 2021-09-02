<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getPermission
 * @api                {get} /api/v1/permissions/:id Find a Permission by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             PermissionSuccessSingleResponse
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('permissions/{permission}', [Controller::class, 'viewPermission'])
    ->name('api.permissions.view')
    ->middleware(['auth:sanctum']);
