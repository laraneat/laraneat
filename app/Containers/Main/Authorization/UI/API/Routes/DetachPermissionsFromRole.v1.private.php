<?php

use App\Containers\Main\Authorization\Actions\DetachPermissionsFromRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('permissions/detach', DetachPermissionsFromRoleAction::class)
    ->name('api.permissions.detach')
    ->middleware(['auth:sanctum']);
