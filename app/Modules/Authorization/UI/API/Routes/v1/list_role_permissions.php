<?php

use App\Modules\Authorization\Actions\ListRolePermissionsAction;
use Illuminate\Support\Facades\Route;

Route::get('roles/{role}/permissions', ListRolePermissionsAction::class)
    ->name('api.roles.permissions.list')
    ->middleware(['auth:sanctum']);
