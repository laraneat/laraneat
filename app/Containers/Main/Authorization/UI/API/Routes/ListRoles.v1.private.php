<?php

use App\Containers\Main\Authorization\Actions\ListRolesAction;
use Illuminate\Support\Facades\Route;

Route::get('roles', ListRolesAction::class)
    ->name('api.roles.list')
    ->middleware(['auth:sanctum']);
