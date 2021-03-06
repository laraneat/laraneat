<?php

use App\Modules\Authorization\Actions\ViewRoleAction;
use Illuminate\Support\Facades\Route;

Route::get('roles/{role}', ViewRoleAction::class)
    ->name('api.roles.view')
    ->middleware(['auth:sanctum']);
