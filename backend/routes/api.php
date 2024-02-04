<?php

use App\Http\Controllers\{
    CategoriesController,
    ClientsCreditorsController,
    UsersController,
    ReleasesController,
    PaymentsController
};
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function(){
    Route::get('signout',[UsersController::class,'signOut']);
    Route::get('whoami',[UsersController::class,'whoAmI']);

    Route::controller(ReleasesController::class)->prefix('releases')->group(function(){
        Route::get('/','index');
        Route::get('show/{release}','show');
        Route::post('create','create');
        Route::put('update/{id}','update');
        Route::delete('delete/{release}','delete');
    });
    Route::controller(PaymentsController::class)->prefix('payments')->group(function(){
        Route::get('/','index');
        Route::get('show/{id}','show');
        Route::post('create','create');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(CategoriesController::class)->prefix('categories')->group(function(){
        Route::get('/','index');
        Route::get('show/{category}','show');
        Route::post('create','create');
        Route::put('update/{id}','update');
        Route::delete('delete/{category}','delete');
    });
    Route::controller(ClientsCreditorsController::class)->prefix('clientscreditors')->group(function(){
        Route::get('/','index');
        Route::get('show/{id}','show');
        Route::post('create','create');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
});
Route::controller(UsersController::class)->prefix('users')->group(function(){
    Route::post('signin','signIn');
    Route::post('signup','signUp');
});
