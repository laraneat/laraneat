<?php

use App\Containers\Main\Authorization\Actions\SyncRolePermissionsAction;
use Illuminate\Support\Facades\Route;

Route::post('permissions/sync', SyncRolePermissionsAction::class)
    ->name('api.permissions.sync')
    ->middleware(['auth:sanctum']);
