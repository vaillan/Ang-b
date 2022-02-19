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
use App\Http\Controllers\IdiomaController\IdiomaController;
use App\Http\Controllers\PropertyTypeController\PropertyTypeController;
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
    //Inicio de sesion
    Route::post('/login', [AuthController::class, 'login']);    //Rutas que no necesitan autenticación
    //Crear una cuenta
    Route::post('/signup', [AuthController::class, 'signUp']);   //Rutas que no necesitan autenticación

    //Obtener idiomas
    Route::get('/get-idiomas', [IdiomaController::class, 'getIdiomas']);

    Route::group([ //Rutas que necesitan autenticación
      'middleware' => 'auth:api'
    ], function() {
        // Route::post('/update-image', [AuthController::class, 'updateImageUser']);
        
        //User
        Route::post('/update-user-enterprise-profile', [AuthController::class, 'update']);
        Route::post('/update-user-configuration',[AuthController::class,'updateConfiguration']);
        Route::get('/logout', [AuthController::class, 'logout']);


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
        
        //Post user enterprise
        Route::post('/create-post-user-client', [PostClientController::class, 'createPostClient']);
        Route::post('/edit-post-user-client', [PostClientController::class, 'editPostClientEnterprise']);
        Route::get('/get-post-type-hose-by-user-enterprise/{user_id}/{type_post}/{post_id?}',[PostClientController::class, 'getPostTypeHoseByUserEnterprise']);
        Route::get('/get-post-type-departament-by-user-enterprise/{user_id}/{type_post}/{post_id?}',[PostClientController::class, 'getPostTypeDepartamentByUserEnterprise']);
        Route::get('/get-post-type-office-by-user-enterprise/{user_id}/{type_post}/{post_id?}',[PostClientController::class, 'getPostTypeOfficeByUserEnterprise']);
        Route::get('/get-post-type-ground-by-user-enterprise/{user_id}/{type_post}/{post_id?}',[PostClientController::class, 'getPostTypeGroundByUserEnterprise']);
        Route::get('/get-post-type-others-by-user-enterprise/{user_id}/{type_post}/{post_id?}',[PostClientController::class, 'getPostTypeOthersByUserEnterprise']);
        Route::delete('/delete-post-user-enterprise/{post_id}/{type_post}/{property_type_id?}', [PostClientController::class, 'deletePostUserEnterprise']);
        
        //property Types
        Route::get('/get-property-type/{id}', [PropertyTypeController::class, 'store']);
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
