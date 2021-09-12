<?php

use App\Containers\Main\User\Actions\UpdateUserAction;
use Illuminate\Support\Facades\Route;

Route::patch('users/{user}', UpdateUserAction::class)
    ->name('api.users.update')
    ->middleware(['auth:sanctum']);
