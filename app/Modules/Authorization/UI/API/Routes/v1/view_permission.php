<?php

use App\Modules\Authorization\Actions\ViewPermissionAction;
use Illuminate\Support\Facades\Route;

Route::get('permissions/{permission}', ViewPermissionAction::class)
    ->name('api.permissions.view')
    ->middleware(['auth:sanctum']);
