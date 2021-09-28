<?php

use App\Modules\Authorization\Actions\AttachPermissionsToRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/{role}/permissions/attach', AttachPermissionsToRoleAction::class)
    ->name('api.roles.permissions.attach')
    ->middleware(['auth:sanctum']);
