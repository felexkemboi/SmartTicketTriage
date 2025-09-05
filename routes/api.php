<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\DashboardController;

Route::get('/tickets', [TicketController::class, 'index']);

Route::get('/tickets/{id}', [TicketController::class, 'show']);

Route::get('/dashboard', [DashboardController::class, 'index']);