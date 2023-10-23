<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware("user")->group(function () {
    Route::controller(ReleasesController::class)->group(function () {
        Route::match(['get','post'],"/release/", "show")->name("show.release");
        Route::get("/release/new", "new")->name("new.release");
        Route::get("/release/edit/{id}", "edit")->name("edit.release");
        Route::POST("/release/create", "create")->name("create.release");
        Route::put("/release/update/", "update")->name("update.release");
        Route::delete("/release/delete/{id}", "delete")->name("delete.release");
    });
    Route::controller(CategoriesController::class)->group(function(){
        Route::delete('/category/delete/{id}','delete')->name('category.delete');
        Route::get('/category/','new')->name('category.new');
        Route::get('/category/edit/{id}','edit')->name('category.edit');
        Route::post('/category/create','create')->name('category.create');
        Route::put('/category/update','update')->name('category.update');
    });

    Route::controller(PaymentsController::class)->group(function(){
        Route::get('/payment/new','new')->name('payment.new');
        Route::get('/payment/edit/{id}','edit')->name('payment.edit');
        Route::post('/payment/create','create')->name('payment.create');
        Route::put('/payment/update/{id}','update')->name('payment.update');
        Route::delete('/payment/delete/{id}','delete')->name('payment.delete');
    });

    Route::controller(CreditorsClientsController::class)->group(function(){
        Route::get('creditorclient/new','new')->name('creditorclient.new');
        Route::get('creditorclient/edit/{id}','edit')->name('creditorclient.edit');
        Route::post('creditorclient/create','create')->name('creditorclient.create');
        Route::put('creditorclient/update/{id}','update')->name('creditorclient.update');
        Route::delete('creditorclient/delete/{id}','delete')->name('creditorclient.delete');
    });
});

Route::controller(UsersController::class)->group(function () {
    Route::get("/signout", "signOut")->name("user.signout");
    Route::get("/", "signin")->name("user.signin");
    Route::get("user/signup", "signUp")->name("user.signup");
    Route::post('/user/auth', 'auth')->name('user.auth');
    Route::post('user/resetpassword', 'resetPassword')->name("user.reset.password");
    Route::get('/user/createpassword/{token}', 'createPassword')->name('user.create.password');
    Route::post('/user/savepassword', 'savePassword')->name('user.save.password');
    Route::get('/user/updatepassword/{token}', 'updatePassword')->name('user.update.password');
    Route::post("user/create", "create")->name("create.user");
});
