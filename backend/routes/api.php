<?php

use App\Http\Controllers\{CategoryController, FinancialRecordController, PaymentController, SupplierAndCustomerController, UserController};
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::post('sign-in','signIn');
    Route::post('sign-up','signUp')->name('signup');
    Route::get('active-user','activateUser');
});

Route::middleware('auth:api')->group(function(){
    Route::controller(PaymentController::class)->prefix('payments')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(CategoryController::class)->prefix('categories')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(SupplierAndCustomerController::class)->prefix('suppliers_and_customers')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(FinancialRecordController::class)->prefix('financial_records')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
});
