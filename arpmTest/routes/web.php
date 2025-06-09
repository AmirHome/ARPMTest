<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EmployeeOfficeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/employee-offices', [EmployeeOfficeController::class, 'index']);
