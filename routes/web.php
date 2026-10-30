<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'create'])->name('registration.create');

Route::post('/register', [RegistrationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('registration.store');

Route::get('/register/sent', [RegistrationController::class, 'sent'])->name('registration.sent');

Route::get('/register/confirm/{registration}', [RegistrationController::class, 'confirm'])
    ->middleware('signed')
    ->name('registration.confirm');
