<?php

use App\Modules\Authorization\Actions\DetachRolesFromUserAction;
use Illuminate\Support\Facades\Route;

Route::post('users/{user}/roles/detach', DetachRolesFromUserAction::class)
    ->name('api.users.roles.detach')
    ->middleware(['auth:sanctum']);
