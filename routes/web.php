<?php

use App\Http\Controllers\antreanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [antreanController::class, 'dashboard']);
