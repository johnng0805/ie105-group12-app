<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(["prefix" => "auth"], function () {
    Route::post("register", [AuthController::class, "register"]);
    Route::post("login", [AuthController::class, "login"]);
});

Route::group([
    "prefix" => "user",
    "middleware" => "auth:api"
], function () {
    Route::get("logout", [UserController::class, "logout"]);
    Route::get("/", [UserController::class, "getSelf"]);
});

Route::group([
    "prefix" => "post",
    "middleware" => "auth:api"
], function () {
    Route::get("/", [PostController::class, "getPost"]);
    Route::post("/", [PostController::class, "upload"]);
    Route::put("/{id}", [PostController::class, "updatePost"]);
    Route::delete("/{id}", [PostController::class, "deletePost"]);
});
