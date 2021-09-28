<?php

use App\Modules\Authorization\Actions\SyncRolePermissionsAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/{role}/permissions/sync', SyncRolePermissionsAction::class)
    ->name('api.roles.permissions.sync')
    ->middleware(['auth:sanctum']);
