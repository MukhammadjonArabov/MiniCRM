<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TicketController;


Route::middleware(['auth:sanctum', 'role:manager,admin', 'permission:ticket.create'])
    ->post('/tickets', [TicketController::class, 'store']);
