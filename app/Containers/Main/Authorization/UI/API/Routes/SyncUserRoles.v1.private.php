<?php

use App\Containers\Main\Authorization\Actions\SyncUserRolesAction;
use Illuminate\Support\Facades\Route;

Route::post('users/{user}/roles/sync', SyncUserRolesAction::class)
    ->name('api.users.roles.sync')
    ->middleware(['auth:sanctum']);
