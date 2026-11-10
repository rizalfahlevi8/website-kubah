<?php

use App\Http\Controllers\ItemsController;
use App\Http\Controllers\StockMovementsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('items.index');
});

// Master Data Barang (Items)
Route::resource('items', ItemsController::class);

// Transaksi Mutasi Stok (Masuk & Keluar)
Route::get('stock-movements', [StockMovementsController::class, 'index'])->name('stock-movements.index');
Route::post('stock-movements', [StockMovementsController::class, 'store'])->name('stock-movements.store');
