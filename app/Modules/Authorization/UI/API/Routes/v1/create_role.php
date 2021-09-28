<?php

use App\Modules\Authorization\Actions\CreateRoleAction;
use Illuminate\Support\Facades\Route;

Route::post('roles', CreateRoleAction::class)
    ->name('api.roles.create')
    ->middleware(['auth:sanctum']);
