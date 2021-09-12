<?php

use App\Containers\Main\Authorization\Actions\AttachRolesToUserAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/attach', AttachRolesToUserAction::class)
    ->name('api.roles.attach')
    ->middleware(['auth:sanctum']);
