<?php

use App\Containers\Main\Authorization\Actions\SyncUserRolesAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/sync', SyncUserRolesAction::class)
    ->name('api.roles.sync')
    ->middleware(['auth:sanctum']);
