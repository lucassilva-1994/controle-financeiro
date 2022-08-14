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
        return to_route('show.release');
    }
     return to_route('index.user');
});

Route::controller(UsersController::class)->group(function () {
    Route::get("/logout", "logout")->name("logout.user");
    Route::get("/index","index")->name("index.user");
    Route::get("user/new", "new")->name("new.user");
    Route::post("user/create", "create")->name("create.user");
    Route::get("user/validate/{token}", "validateUser")->name("validate.user");
    Route::post("/auth", "auth")->name("auth.user");
    //RESET PASSWORD
    Route::get("/user/resetpassword", "resetPassword")->name("resetpassword.user");
    Route::get("/user/newpassword/{token}", "newPassword")->name("newpassword.user");
    Route::POST("/user/updatetoken", "updateToken")->name("updatetoken.user");
    Route::POST("/user/updatepassword", "updatePassword")->name("updatepassword.user");
});
