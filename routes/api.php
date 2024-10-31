<?php

use App\Http\Controllers\Api\AuthController;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::Post('/login',[AuthController::class , 'login']);
Route::middleware('auth:sanctum')->post('/logout',[AuthController::class , 'logout']);
Route::Post('/register',[AuthController::class , 'register']);

