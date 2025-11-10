<?php

use App\Http\Controllers\API\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/statistics', [TicketController::class, 'statistics']);
