<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

//GROUP ROUTING (->GROUP)
Route::controller(ReleasesController::class)->middleware("user")->group(function () {
    //ROUTING NAMED (->NAME)
    Route::get("/release/", "index")->name("index.release");
    Route::get("/release/new", "new")->name("new.release");
    Route::get("/release/edit/{id}", "edit")->name("edit.release");
    Route::POST("/release/create", "create")->name("create.release");
    Route::PUT("/release/update/{id_release}", "update")->name("update.release");
    Route::get("/release/junks", "junk")->name("junk.release");
    Route::get("/release/remove/{id_release}", "remove")->name("remove.release");
    Route::get("/release/restore/{id_release}", "restore")->name("restore.release");
    Route::get("/release/delete/{id_release}", "delete")->name("delete.release");
});

Route::get("/", function() {
    if (session()->get('id_user')) {
        return to_route('index.release');
    }
     return to_route('index.user');
});

Route::controller(UsersController::class)->group(function () {
    Route::get("/logout", "logout")->name("logout.user");
    Route::get("/","signin")->name("user.signin");
    Route::get("user/signup", "signUp")->name("user.signup");
    Route::post('/user/auth','auth')->name('user.auth');
    Route::post('user/resetpassword','resetPassword')->name("user.reset.password");
    Route::get('/user/createpassword/{token}','createPassword')->name('user.create.password');
    Route::post('/user/savepassword','savePassword')->name('user.save.password');
    Route::get('/user/updatepassword/{token}','updatePassword')->name('user.update.password');

    Route::post("user/create", "create")->name("create.user");
    //RESET PASSWORD

});
