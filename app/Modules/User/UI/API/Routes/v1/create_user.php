<?php

use App\Modules\User\Actions\CreateUserAction;
use Illuminate\Support\Facades\Route;

Route::post('/users', CreateUserAction::class)
    ->name('api.users.create');
