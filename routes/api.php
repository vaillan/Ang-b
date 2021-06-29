<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController\AuthController;
use App\Http\Controllers\PostUserController\PostUserController;
use App\Http\Controllers\PostClientController\PostClientController;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\LocalidadController\LocalidadController;

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

        //Post user
        Route::get('/get-posts-user/{id}', [PostUserController::class, 'getPostUser']);
        Route::post('/post-user', [PostUserController::class,'postUser']);
        //Post client  
        Route::post('/post-user-client', [PostClientController::class, 'createPostClient']);
        //Mexico address
        Route::post('/search-mexico-localidades', [LocalidadController::class,'searchMexicoLocalidades']);
    });
});
