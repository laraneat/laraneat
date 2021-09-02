<?php

/**
 * @apiGroup           RolePermission
 * @apiName            getRole
 * @api                {get} /api/v1/roles/:id Find a Role by ID
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated User
 *
 * @apiUse             RoleSuccessSingleResponse
 */

use App\Containers\Main\Authorization\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('roles/{role}', [Controller::class, 'viewRole'])
    ->name('api.roles.view')
    ->middleware(['auth:sanctum']);
