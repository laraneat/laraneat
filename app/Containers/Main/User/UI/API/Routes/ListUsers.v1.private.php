<?php

use App\Containers\Main\User\Actions\ListUsersAction;
use Illuminate\Support\Facades\Route;

Route::get('users', ListUsersAction::class)
    ->name('api.users.list')
    ->middleware(['auth:sanctum']);
