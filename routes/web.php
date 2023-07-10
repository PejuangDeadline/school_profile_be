<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\InstitutionController;
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
//Login Controller
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
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

    //Institution
    Route::get('/institution', [InstitutionController::class, 'index']);
    Route::post('/institution/store', [InstitutionController::class, 'store']);
    Route::get('/institution/profile/{id_inst}', [InstitutionController::class, 'createProfile']);
    Route::get('/institution/profile-edit/{id_profile}', [InstitutionController::class, 'editProfile']);
    Route::post('/institution/profile/store', [InstitutionController::class, 'storeProfile']);
    Route::post('/institution/profile/update', [InstitutionController::class, 'updateProfile']);

    //branch
    Route::post('/branch/store', [InstitutionController::class, 'storeBranch']);

    //ajaxArea
    Route::get('/ajax/mappingCity/{province_id}', 'App\Http\Controllers\AjaxAreaController@searchCity')->name('mappingCity');
    Route::get('/ajax/mappingDistrict/{city_id}', 'App\Http\Controllers\AjaxAreaController@searchDistrict')->name('mappingDistrict');
    Route::get('/ajax/mappingSubDistrict/{district_id}', 'App\Http\Controllers\AjaxAreaController@searchSubDistrict')->name('mappingSubDistrict');
    Route::get('/ajax/mappingZipcode/{subdistrict_id}', 'App\Http\Controllers\AjaxAreaController@searchZipcode')->name('mappingZipcode');
});