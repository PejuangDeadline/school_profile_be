<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MstFeatureController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListBranchController;
use App\Http\Controllers\CultureController;
use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\PublicInfoController;
use App\Http\Controllers\VisionController;

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
    Route::get('/dropdown', [DropdownController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/dropdown/store', [DropdownController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::patch('/dropdown/update/{id}', [DropdownController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::delete('/dropdown/delete/{id}', [DropdownController::class, 'delete'])->middleware(['checkRole:Super Admin']);

    //Rules Controller
    Route::get('/rule', [RulesController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/rule/store', [RulesController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::patch('/rule/update/{id}', [RulesController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::delete('/rule/delete/{id}', [RulesController::class, 'delete'])->middleware(['checkRole:Super Admin']);

    //Feature Controller
    Route::get('/feature', [MstFeatureController::class, 'index']);
    Route::post('/feature/store', [MstFeatureController::class, 'store']);
    Route::patch('/feature/update/{id}', [MstFeatureController::class, 'update']);
    Route::delete('/feature/delete/{id}', [MstFeatureController::class, 'delete']);

    //User Controller
    Route::get('/user', [UserController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/user/store', [UserController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::patch('/user/update/{user}',[UserController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::get('/user/revoke/{user}',[UserController::class, 'revoke'])->middleware(['checkRole:Super Admin']);
    Route::get('/user/access/{user}',[UserController::class, 'access'])->middleware(['checkRole:Super Admin']);

    //Institution
    Route::get('/institution', [InstitutionController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/institution/store', [InstitutionController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::get('/institution/profile/{id_inst}', [InstitutionController::class, 'createProfile'])->middleware(['checkRole:Super Admin']);
    Route::get('/institution/profile-edit/{id_profile}', [InstitutionController::class, 'editProfile'])->middleware(['checkRole:Super Admin']);
    Route::post('/institution/profile/store', [InstitutionController::class, 'storeProfile'])->middleware(['checkRole:Super Admin']);
    Route::post('/institution/profile/update', [InstitutionController::class, 'updateProfile'])->middleware(['checkRole:Super Admin']);

    //Facility
    Route::get('/facility', [FacilityController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/facility/store', [FacilityController::class, 'store'])->middleware(['checkRole:User']);
    Route::post('/facility/update', [FacilityController::class, 'update'])->middleware(['checkRole:User']);
    Route::post('/facility/update/icon', [FacilityController::class, 'updateIcon'])->middleware(['checkRole:User']);
    Route::post('/facility/delete', [FacilityController::class, 'delete'])->middleware(['checkRole:User']);

    //branch
    // Route::get('/branch', [InstitutionController::class, 'indexBranch'])->middleware(['checkRole:Super Admin']);
    // Route::post('/branch/store', [InstitutionController::class, 'storeBranch'])->middleware(['checkRole:Super Admin']);
    // Route::post('/branch/user', [InstitutionController::class, 'userBranch'])->middleware(['checkRole:Super Admin']);

    //gallery
    Route::get('/gallery', [GalleryController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/gallery/store', [GalleryController::class, 'store'])->middleware(['checkRole:User']);
    Route::post('/gallery/update', [GalleryController::class, 'update'])->middleware(['checkRole:User']);
    Route::post('/gallery/delete', [GalleryController::class, 'delete'])->middleware(['checkRole:User']);

    //ListBranch Controller
    Route::get('/branch/{id}', [ListBranchController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/branch/store', [ListBranchController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::get('/branch/edit/{id_branch}', [ListBranchController::class, 'editBranch'])->middleware(['checkRole:Super Admin']);
    Route::post('/branch/update', [ListBranchController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::delete('/branch/delete/{id}', [ListBranchController::class, 'delete'])->middleware(['checkRole:Super Admin']);
    Route::put('/branch/upload-logo/{id}', [ListBranchController::class, 'uploadLogo'])->middleware(['checkRole:Super Admin']);

    //culture
    Route::get('/culture/{id}', [CultureController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/culture/store', [CultureController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::post('/culture/update', [CultureController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::post('/culture/delete', [CultureController::class, 'delete'])->middleware(['checkRole:Super Admin']);

    //vision
    Route::get('/vision/{id}', [VisionController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/vision/store', [VisionController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::post('/vision/update', [VisionController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::post('/vision/delete', [VisionController::class, 'delete'])->middleware(['checkRole:Super Admin']);
    Route::post('/vision/active', [VisionController::class, 'active'])->middleware(['checkRole:Super Admin']);
    Route::post('/vision/deactive', [VisionController::class, 'deactive'])->middleware(['checkRole:Super Admin']);

    //advantage
    Route::get('/advantage/{id}', [AdvantageController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/advantage/store', [AdvantageController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::post('/advantage/update', [AdvantageController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::post('/advantage/delete', [AdvantageController::class, 'delete'])->middleware(['checkRole:Super Admin']);
    Route::post('/advantage/active', [AdvantageController::class, 'active'])->middleware(['checkRole:Super Admin']);
    Route::post('/advantage/deactive', [AdvantageController::class, 'deactive'])->middleware(['checkRole:Super Admin']);

    //Public Info
    Route::get('/public-info', [PublicInfoController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/public-info/store', [PublicInfoController::class, 'store'])->middleware(['checkRole:User']);
    Route::post('/public-info/update', [PublicInfoController::class, 'update'])->middleware(['checkRole:User']);
    Route::post('/public-info/delete', [PublicInfoController::class, 'delete'])->middleware(['checkRole:User']);

    //ajaxArea
    Route::get('/ajax/mappingCity/{province_id}', 'App\Http\Controllers\AjaxAreaController@searchCity')->name('mappingCity');
    Route::get('/ajax/mappingDistrict/{city_id}', 'App\Http\Controllers\AjaxAreaController@searchDistrict')->name('mappingDistrict');
    Route::get('/ajax/mappingSubDistrict/{district_id}', 'App\Http\Controllers\AjaxAreaController@searchSubDistrict')->name('mappingSubDistrict');
    Route::get('/ajax/mappingZipcode/{subdistrict_id}', 'App\Http\Controllers\AjaxAreaController@searchZipcode')->name('mappingZipcode');
});
