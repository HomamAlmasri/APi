<?php

use App\Http\Controllers\Api\V1\TicketController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\AuthorTicketsController;
use Illuminate\Support\Facades\Route;


//-----------------------------------------TICKETS--------------------------------------------------------------
Route::middleware('auth:sanctum')->apiResource('tickets',TicketController::class);
//-----------------------------------------TICKETS--------------------------------------------------------------


//-----------------------------------------AUTHOR--------------------------------------------------------------
Route::middleware('auth:sanctum')->apiResource('authors', AuthorController ::class);
Route::middleware('auth:sanctum')->get('authors/{author}/tickets',
    [AuthorController::class,'authorTickets']);
//-----------------------------------------AUTHOR--------------------------------------------------------------

