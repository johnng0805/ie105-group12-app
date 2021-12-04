<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    "middleware" => "auth"
], function () {
    Route::get("logout", [UserController::class, "logout"])->name("logout");
    Route::view("/", "home");
    Route::get("post", [PostController::class, "getPost"]);
    Route::post("post", [PostController::class, "upload"]);
    Route::delete("/post/{id}", [PostController::class, "deletePost"]);
    Route::put("/post/{id}", [PostController::class, "updatePost"]);
});

Route::group([
    "prefix" => "auth"
], function () {
    Route::view("login", "login")->name("login");
    Route::post("login", [AuthController::class, "login"])->block();
    Route::view("register", "register");
    Route::post("register", [AuthController::class, "register"]);
});
