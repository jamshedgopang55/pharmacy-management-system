<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix'=>'admin','middleware' => 'ForceJsonResponse'] ,function(){
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
    Route::middleware('auth:api')->group(function () {
        Route::get('/', function () {
            return response()->json([
                'status' => true
            ]);
        });
        Route::controller(AuthController::class)->group(function () {
            Route::get('/test','test');
    });
        
    });
});