<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\user\DepartmentController;
use App\Http\Controllers\user\ParkingSlotController;
use App\Http\Controllers\user\ReservationController;
use App\Http\Controllers\user\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login',[LoginController::class, 'userLogin']);
Route::group( ['prefix' => '/v1','middleware' => ['auth:user-api','scopes:user'] ],function(){
   // authenticated staff routes here 
    Route::get('dashboard',[LoginController::class, 'userDashboard']);
    Route::post('/logout',[LoginController::class, 'logoutUser']);

    Route::post('user/update',[UserController::class, 'update']);

    Route::get('department/all',[DepartmentController::class, 'index']);
    Route::get('department/show/{id}',[DepartmentController::class, 'show']);


    Route::get('parking_slot/all',[ParkingSlotController::class, 'index']);


    Route::get('reservation/show/{id}',[ReservationController::class, 'show']);
    Route::post('reservation/update/{id}',[ReservationController::class, 'update']);
    Route::delete('reservation/delete/{reservation}',[ReservationController::class, 'destroy']);
    
});   
