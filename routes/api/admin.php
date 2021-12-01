<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\ParkingSlotController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\admin\UserController;

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

Route::post('/login',[LoginController::class, 'adminLogin']);
Route::group( ['prefix' => '/v1','middleware' => ['auth:admin-api','scopes:admin'] ],function(){
   // authenticated staff routes here 
    Route::get('details',[LoginController::class, 'details']);

    Route::get('index',[AdminController::class, 'index']);
    Route::post('create',[AdminController::class, 'store']);
    Route::get('show/{id}',[AdminController::class, 'show']);
    Route::post('update/{id}',[AdminController::class, 'update']);
    Route::delete('delete/{admin}',[AdminController::class, 'destroy']);
    

    Route::get('department/index',[DepartmentController::class, 'index']);
    Route::post('department/create',[DepartmentController::class, 'store']);
    Route::get('department/show/{id}',[DepartmentController::class, 'show']);
    Route::post('department/update/{id}',[DepartmentController::class, 'update']);
    Route::delete('department/delete/{department}',[DepartmentController::class, 'destroy']);


    Route::get('parking_slot/index',[ParkingSlotController::class, 'index']);
    Route::post('parking_slot/create',[ParkingSlotController::class, 'store']);
    Route::get('parking_slot/show/{id}',[ParkingSlotController::class, 'show']);
    Route::post('parking_slot/update/{id}',[ParkingSlotController::class, 'update']);
    Route::delete('parking_slot/delete/{slot}',[ParkingSlotController::class, 'destroy']);
    Route::get('parking_slot/qrcode/{id}', [ParkingSlotController::class, 'generate']);
    Route::get('parking_slot/qrImage/{id}', [ParkingSlotController::class, 'qrImage']);


    Route::get('user/index',[UserController::class, 'index']);
    Route::post('user/create',[UserController::class, 'store']);
    Route::get('user/show/{id}',[UserController::class, 'show']);
    Route::post('user/update/{id}',[UserController::class, 'update']);
    Route::delete('user/delete/{user}',[UserController::class, 'destroy']);


    Route::post('/logout',[LoginController::class, 'logout']);

    Route::get('dashboard/getData',[DashboardController::class, 'getData']);


});
