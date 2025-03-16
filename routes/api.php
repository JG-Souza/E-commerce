<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users', [ApiController::class, 'showUsers']);

Route::get('/admins', [ApiController::class, 'showAdmins']);
