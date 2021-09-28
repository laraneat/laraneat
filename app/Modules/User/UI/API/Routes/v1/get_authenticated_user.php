<?php

use App\Modules\User\Actions\GetAuthenticatedUserAction;
use Illuminate\Support\Facades\Route;

Route::get('user', GetAuthenticatedUserAction::class)
    ->name('api.user')
    ->middleware(['auth:sanctum']);
