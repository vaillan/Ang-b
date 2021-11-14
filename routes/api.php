<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\PostUserController\PostUserController;
use App\Http\Controllers\PostClientController\PostClientController;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\LocalidadController\LocalidadController;
use App\Http\Controllers\DepartamentController\DepartamentController;
use App\Http\Controllers\GroundController\GroundController;
use App\Http\Controllers\HouseController\HouseController;
use App\Http\Controllers\OfficeController\OfficeController;
use App\Http\Controllers\ServiceController\ServiceController;
use App\Http\Controllers\GeneralCategoryController\GeneralCategoryController;
use App\Http\Controllers\ExteriorController\ExteriorController;
use App\Http\Controllers\ConservationStateController\ConservationStateController;
use App\Http\Controllers\DivisaController\DivisaController;
use App\Http\Controllers\RentaOpcionController\RentaOpcionController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signUp']);

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::post('/update-image', [AuthController::class, 'updateImageUser']);
        Route::post('/update', [AuthController::class, 'update']);

        //property
        Route::get('/get-house-type', [HouseController::class, 'getHouseType']);
        Route::get('/get-departament-type', [DepartamentController::class, 'getDepartamentType']);
        Route::get('/get-office-type', [OfficeController::class, 'getOfficeType']);
        Route::get('/get-ground-type', [GroundController::class, 'getGroundType']);

        //Post user
        Route::get('/get-posts-user/{id}', [PostUserController::class, 'getPostUser']);
        Route::post('/post-user', [PostUserController::class,'createPostUser']);
        Route::delete('/delete-post-user/{id}', [PostUserController::class,'deletePostUser']);
        Route::get('/get-all-post-users', [PostUserController::class, 'getAllPostUsers']);
        
        //Post client
        Route::post('/create-post-user-client', [PostClientController::class, 'createPostClient']);
        //Mexico address
        Route::post('/search-mexico-localidades', [LocalidadController::class,'searchMexicoLocalidades']);

        //PropertyService
        Route::get('/get-property-services', [ServiceController::class, 'getServicesProperty']);
        
        //GeneralCategories
        Route::get('/get-general-categories',[GeneralCategoryController::class, 'getGeneralCategories']);
        
        //Exterios
        Route::get('/get-exteriors', [ExteriorController::class, 'getExteriors']);
        
        //ConservationState
        Route::get('/get-conservation-state', [ConservationStateController::class, 'getConservationState']);
        
        //Divisas
        Route::get('/get-divisas', [DivisaController::class, 'getDivisas']);
        
        //Renta opciones
        Route::get('/get-renta-opciones', [RentaOpcionController::class, 'getRentaOpciones']);
    });
});
