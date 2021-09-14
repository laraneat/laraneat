<?php

use App\Containers\Main\Authorization\Actions\AttachRolesToUserAction;
use Illuminate\Support\Facades\Route;

Route::post('users/{user}/roles/attach', AttachRolesToUserAction::class)
    ->name('api.users.roles.attach')
    ->middleware(['auth:sanctum']);
