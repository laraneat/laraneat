<?php

use App\Containers\Main\User\Actions\CreateUserAction;
use Illuminate\Support\Facades\Route;

Route::post('/users', CreateUserAction::class)
    ->name('api.users.create');
