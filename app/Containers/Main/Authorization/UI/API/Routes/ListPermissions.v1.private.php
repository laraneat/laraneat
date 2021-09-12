<?php

use App\Containers\Main\Authorization\Actions\ListPermissionsAction;
use Illuminate\Support\Facades\Route;

Route::get('permissions', ListPermissionsAction::class)
    ->name('api.permissions.list')
    ->middleware(['auth:sanctum']);
