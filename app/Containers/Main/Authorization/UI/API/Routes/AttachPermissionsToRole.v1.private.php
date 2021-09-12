<?php

use App\Containers\Main\Authorization\Actions\AttachPermissionsToRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('permissions/attach', AttachPermissionsToRoleAction::class)
    ->name('api.permissions.attach')
    ->middleware(['auth:sanctum']);
