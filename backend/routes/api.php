<?php

use App\Http\Controllers\{CategoryController, FinancialRecordController, PaymentController, SupplierAndCustomerController, UserController};
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->prefix('users')->group(function(){
    Route::post('sign-in','signIn');
    Route::post('sign-up','signUp');
    Route::get('activate-account','activateAccount');
    Route::post('forgot-password','forgotPassword')->name('forgot.password');
    Route::get('/validate-token','validateToken');
});

Route::middleware('auth:api')->group(function(){
    Route::controller(UserController::class)->prefix('users')->group(function(){
        Route::post('restore-password','restorePassword')->name('restore.password');
        Route::get('sign-out','signOut');
    });

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
        Route::get('calculate-income-expense','calculateIncomeExpense');
    });
});
