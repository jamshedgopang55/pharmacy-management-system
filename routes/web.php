<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\MedicineContrller;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\dashboardController;
use App\Http\Controllers\Admin\locationController;
use App\Http\Controllers\Admin\OrderController;

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





Route::group(['prefix' => 'admin',  'controller' => AuthController::class], function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    
        Route::resource('location', locationController::class);
        Route::resource('category', CategoryController::class);
        Route::resource('medicines', MedicineContrller::class);
        Route::resource('customer', CustomerController::class);
        Route::resource('order', OrderController::class);
        Route::controller(dashboardController::class)->group(function () {
            Route::get('dashboard','index');
        });
    });

