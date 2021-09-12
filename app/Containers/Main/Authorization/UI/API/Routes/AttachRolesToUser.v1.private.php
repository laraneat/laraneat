<?php

use App\Containers\Main\Authorization\Actions\AttachUserToRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/attach', AttachUserToRoleAction::class)
    ->name('api.roles.attach')
    ->middleware(['auth:sanctum']);
