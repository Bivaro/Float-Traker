<?php

use App\Http\Controllers\TransactionController;

Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
Route::post('/add', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::post('/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/delete/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
Route::get('/download-pdf', [TransactionController::class, 'downloadPdf'])->name('transactions.downloadPdf');

