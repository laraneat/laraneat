<?php

use App\Containers\Main\User\Actions\ViewUserAction;
use Illuminate\Support\Facades\Route;

Route::get('users/{user}', ViewUserAction::class)
    ->name('api.users.view')
    ->middleware(['auth:sanctum']);
