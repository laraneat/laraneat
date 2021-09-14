<?php

use App\Containers\Main\Authorization\Actions\ListUserRolesAction;
use Illuminate\Support\Facades\Route;

Route::get('users/{user}/roles', ListUserRolesAction::class)
    ->name('api.users.roles.list')
    ->middleware(['auth:sanctum']);
