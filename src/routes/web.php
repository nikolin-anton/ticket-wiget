<?php

use App\Http\Controllers\API\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layout.admin');
});

Route::get('/widget', function () {
    return view('ticket.widget');
})->name('widget');

Route::prefix('/admin')->middleware('auth')->group(function () {
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{ticket}', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::get('/files/{media}/download', [TicketController::class, 'downloadFile'])->name('tickets.downloadFile');
    Route::get('/files/{ticket}/download-all', [TicketController::class, 'downloadAllFile'])->name('tickets.downloadAllFile');
});
