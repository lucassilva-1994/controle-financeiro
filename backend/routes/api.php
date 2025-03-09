<?php

use App\Http\Controllers\{CategoryController, FinancialPlanController, FinancialPlanItemController, FinancialRecordController, PaymentController, ShoppingListController, ShoppingListItemController, SupplierAndCustomerController, UserController};
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
        Route::put('restore-password','restorePassword')->name('restore.password');
        Route::get('sign-out','signOut');
        Route::get('profile','profile');
    });

    Route::controller(PaymentController::class)->prefix('payments')->group(function(){
        Route::get('show','show');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(CategoryController::class)->prefix('categories')->group(function(){
        Route::get('show','show');
        Route::get('show-without-pagination','showWithoutPagination');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(SupplierAndCustomerController::class)->prefix('suppliers_and_customers')->group(function(){
        Route::get('show','show');
        Route::get('show-without-pagination','showWithoutPagination');
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
    Route::controller(FinancialPlanController::class)->prefix('financial_plans')->group(function(){
        Route::get('show','show');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
    Route::controller(FinancialPlanItemController::class)->prefix('financial_plans_items')->group(function(){
        Route::get('show-by-financial-plan/{financial_plan_id}','showByFinancialPlan');
        Route::get('show-by-id/{id}','showById');
        Route::post('store','store');
        Route::patch('toggle-check-financial-plan-item', 'toggleCheckFinancialPlanItem');
        Route::put('update/{id}','update');
        Route::delete('delete/{id}','delete');
    });
});
