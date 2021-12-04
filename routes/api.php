<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ClassroomController;
use Illuminate\Support\Facades\Route;

Route::get("/", fn(): array => [
    "success" => true,
]);

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);
    Route::post("logout", LogoutController::class)->middleware("auth:sanctum");
});

Route::middleware("auth:sanctum")->group(function (): void {
    Route::prefix("me")->group(function (): void {
        Route::get("/", UserController::class);

        Route::get("/owned-classrooms", [ClassroomController::class, "ownedIndex"]);
    });

    Route::post("/classrooms", [ClassroomController::class, "store"]);
    Route::put("/classrooms/{classroom}", [ClassroomController::class, "update"]);
    Route::delete("/classrooms/{classroom}", [ClassroomController::class, "delete"]);
    Route::put("/classrooms/{classroom}/archive", [ClassroomController::class, "archive"]);
    Route::delete("/classrooms/{classroom}/archive", [ClassroomController::class, "unarchive"]);
});
