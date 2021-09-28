<?php

use App\Modules\Authorization\Actions\DeleteRoleAction;
use Illuminate\Support\Facades\Route;

Route::delete('roles/{role}', DeleteRoleAction::class)
    ->name('api.roles.delete')
    ->middleware(['auth:sanctum']);
