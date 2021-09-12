<?php

use App\Containers\Main\Authorization\Actions\DetachRolesFromUserAction;
use Illuminate\Support\Facades\Route;

Route::post('roles/detach', DetachRolesFromUserAction::class)
    ->name('api.roles.detach')
    ->middleware(['auth:sanctum']);
