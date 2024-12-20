<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\productController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\cartController;



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

Route::post('/uploadProduct',[productController::class,'createProduct']);
Route::get('/Product/{id?}',[productController::class,'view']);
// Route::get('/Product',[productController::class,'view']);


// user models
Route::post('/signup',[UserController::class,'signup']);
Route::post('/login',[UserController::class,'loginCheck']);

// Order details using Repository pattern
Route::post('/addCart',[cartController::class,'addCart']);
Route::get('/getCart/{id}',[cartController::class,'getCart']);
Route::put('/remove_item/{id}',[cartController::class,'remove_item']);
Route::post('/place_order',[OrderController::class,'create']);
