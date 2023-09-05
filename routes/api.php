<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\UserController;
use App\http\Controllers\mejaController;
use App\http\Controllers\menuController;
use App\http\Controllers\transaksiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);


// Admin
Route::group(['middleware' => ['jwt.verify:admin']],function(){
    
    // User Group
    Route::get('/profile',[UserController::class, 'profile_admin']);
    Route::post('/user', [UserController::class, 'register']);
    Route::get('/user',[UserController::class, 'get']);
    Route::put('/user/{id}', [UserController::class, 'edit']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);

    //meja
    Route::get('/meja',[mejaController::class,'getmeja']);
    Route::post('/meja',[mejaController::class,'createmeja']);
    Route::put('/meja/{id}',[mejaController::class,'updatemeja']);
    Route::delete('meja/{id}',[mejaController::class,'destroymeja']);
    Route::get('detailmeja/{id}',[mejaController::class,'getdetailmeja']);

    //menu
    Route::get('/menu',[menuController::class,'get']);
    Route::post('/menu',[menuController::class,'createmenu']);
    Route::put('/menu/{id}',[menuController::class,'updatemenu']);
    Route::delete('menu/{id}',[menuController::class,'destroymenu']);
    Route::get('detailmenu/{id}',[menuController::class,'getdetailmenu']);

});

//Kasir
Route::group(['middleware' => ['jwt.verify:kasir']],function(){

    //transaksi
    Route::get('/transaksi',[transaksiController::class,'gettransaksi']);
    Route::post('/transaksi',[transaksiController::class,'createtransaksi']);
    Route::put('/transaksi/{id}',[transaksiController::class,'updatetransaksi']);
    Route::delete('transaksi/{id}',[transaksiController::class,'destroytransaksi']);
    Route::get('dtltransaksi/{id}',[transaksiController::class,'getdtltransaksi']);

    //detail transaksi
    Route::get('/detail',[transaksiController::class,'getdetail']);
    Route::post('/detail',[transaksiController::class,'createdetail']);
    Route::put('/transaksidetail/{id}',[transaksiController::class,'updatedetail']);
    Route::delete('transaksidetail/{id}',[transaksiController::class,'destroydetail']);
    Route::get('transaksidetail/{id}',[transaksiController::class,'getdetailtransaksi']);

});

//Manager
Route::group(['middleware' => ['jwt.verify:manager']],function(){

    //detail transaksi
    Route::get('/detail',[transaksiController::class,'getdetail']);
    Route::get('transaksidetail/{id}',[transaksiController::class,'getdetailtransaksi']);
});