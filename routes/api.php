<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;

// -------------------  Ticket ------------------------ 
Route::middleware(['auth:sanctum', 'role:manager|admin', 'permission:ticket.create'])
    ->post('/tickets', [TicketController::class, 'store']);

Route::middleware(['auth:sanctum', 'role:manager|admin', 'permission:ticket.view'])
    ->get('/tickets', [TicketController::class, 'index']);

Route::middleware(['auth:sanctum', 'role:manager|admin', 'permission:ticket.view'])
    ->get('/tickets/{id}', [TicketController::class, 'show']);    

Route::middleware(['auth:sanctum', 'role:manager|admin', 'permission:ticket.update'])
    ->match(['put', 'patch'], '/tickets/{id}', [TicketController::class, 'update']);  
    
Route::middleware(['auth:sanctum', 'role:manager|admin', 'permission:ticket.delete'])
    ->delete('/tickets/{id}', [TicketController::class, 'destroy']);   
    
// ------------------  Auth  ------------------------  
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
});    