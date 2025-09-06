<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;

Route::get('/tickets', [TicketController::class, 'index']);

Route::post('/tickets', [TicketController::class, 'store']);

Route::get('/tickets/{id}', [TicketController::class, 'show']);

Route::patch('/tickets/{id}', [TicketController::class, 'update']);

Route::get('/dashboard', [DashboardController::class, 'index']);