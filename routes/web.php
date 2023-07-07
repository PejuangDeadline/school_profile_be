<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Home Controller
Route::get('/home', [HomeController::class, 'index']);

//Dropdown Controller
Route::get('/dropdown', [DropdownController::class, 'index']);
Route::post('/dropdown/store', [DropdownController::class, 'store']);
Route::patch('/dropdown/update/{id}', [DropdownController::class, 'update']);
Route::delete('/dropdown/delete/{id}', [DropdownController::class, 'delete']);

//Rules Controller
Route::get('/rule', [RulesController::class, 'index']);
Route::post('/rule/store', [RulesController::class, 'store']);
Route::patch('/rule/update/{id}', [RulesController::class, 'update']);
Route::delete('/rule/delete/{id}', [RulesController::class, 'delete']);

//User Controller
Route::get('/user', [UserController::class, 'index']);
Route::post('/user/store', [UserController::class, 'store']);
Route::patch('/user/update/{user}',[UserController::class, 'update']);
Route::get('/user/revoke/{user}',[UserController::class, 'revoke']);
Route::get('/user/access/{user}',[UserController::class, 'access']);
