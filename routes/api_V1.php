<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\AuthorTicketsController;
use Illuminate\Support\Facades\Route;


//-----------------------------------------TICKETS--------------------------------------------------------------
Route::middleware('auth:sanctum')->group(function () {
Route::apiResource('tickets',TicketController::class)->except('update');
Route::put('/tickets/{ticket}',[TicketController::class,'replace']);
Route::patch('/tickets/{ticket}',[TicketController::class,'update']);
});
//-----------------------------------------TICKETS--------------------------------------------------------------

//-----------------------------------------AUTHOR--------------------------------------------------------------
Route::middleware('auth:sanctum')->apiResource('authors', AuthorController ::class);
Route::middleware('auth:sanctum')->apiResource('authors.tickets', AuthorTicketsController::class)->except('update');
Route::put('authors/{author}/tickets/{ticket}',[AuthorTicketsController::class,'replace']);
Route::patch('authors/{author}/tickets/{ticket}',[AuthorTicketsController::class,'update']);
//-----------------------------------------AUTHOR--------------------------------------------------------------

