<?php

use App\Containers\Main\Authorization\Actions\DetachPermissionsFromRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/{role}/permissions/detach', DetachPermissionsFromRoleAction::class)
    ->name('api.roles.permissions.detach')
    ->middleware(['auth:sanctum']);
