<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TaskController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

//Open Routes
Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

//Protected Routes
Route::group([
    "middleware" => ["auth:sanctum"]
], function(){

    Route::get("categories", [CategoryController::class, "index"]);
    Route::post("categories", [CategoryController::class, "store"]);
    Route::delete("categories/{id}", [CategoryController::class, "destroy"]);

    Route::get("tasks", [TaskController::class, "index"]);
    Route::post("tasks", [TaskController::class, "store"]);
    Route::put("tasks/{id}", [TaskController::class, "update"]);
    Route::patch("tasks/{id}", [TaskController::class, "markFinished"]);
    Route::delete("tasks/{id}", [TaskController::class, "destroy"]);

    Route::get("logout", [AuthController::class, "logout"]);

});
