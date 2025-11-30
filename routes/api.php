<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;


Route::middleware(['auth:sanctum', 'role:manager,admin', 'permission:ticket.create'])
    ->post('/tickets', [TicketController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:manager,admin', 'permission:ticket.view'])
    ->get('/tickets', [TicketController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:manager,admin', 'permission:ticket.view'])
    ->get('/tickets/{id}', [TicketController::class, 'show']);    

Route::middleware(['auth:sanctum', 'role:manager,admin', 'permission:ticket.update'])
    ->match(['put', 'patch'], '/tickets/{id}', [TicketController::class, 'update']);  
    
Route::middleware(['auth:sanctum', 'role:manager,admin', 'permission:ticket.delete'])
    ->delete('/tickets/{id}', [TicketController::class, 'destroy']);    