<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/','products');

Route::resource('products',\App\Http\Controllers\ProductController::class);

Route::get('orders',[\App\Http\Controllers\OrderController::class,'index'])->name('orders.index');
Route::get('create/create',[\App\Http\Controllers\OrderController::class,'create'])->name('orders.create');
Route::post('orders',[\App\Http\Controllers\OrderController::class,'store'])->name('orders.store');
Route::get('orders/{order}',[\App\Http\Controllers\OrderController::class,'show'])->name('orders.show');
Route::delete('orders/{order}',[\App\Http\Controllers\OrderController::class,'destroy'])->name('orders.destroy');
Route::post('orders/change_status/{order}',[\App\Http\Controllers\OrderController::class,'changeStatus'])->name('order.change_status');
