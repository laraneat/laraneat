<?php

use App\Containers\Main\User\Actions\DeleteUserAction;
use Illuminate\Support\Facades\Route;

Route::delete('users/{user}', DeleteUserAction::class)
    ->name('api.users.delete')
    ->middleware(['auth:sanctum']);
