<?php

use App\Modules\Authorization\Actions\DetachPermissionsFromRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/{role}/permissions/detach', DetachPermissionsFromRoleAction::class)
    ->name('api.roles.permissions.detach')
    ->middleware(['auth:sanctum']);
