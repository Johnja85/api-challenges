<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChallengeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function (){

    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
    Route::post('user', [UserController::class, 'store'])->name('users.store');

    Route::middleware('auth:api')->group(function (){
        Route::get('user',[UserController::class, 'index'])->name('user.index');
        Route::get('user/{id}',[UserController::class, 'show'])->name('user.show');
        Route::put('user/{id}',[UserController::class, 'update'])->name('user.update');
        Route::resource('challenges', ChallengeController::class)->except(['delete']);
        Route::resource('videos', VideoController::class)->except(['delete']);
    });
    

});