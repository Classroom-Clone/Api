<?php

declare(strict_types=1);

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

Route::get("/", fn(): Response => response()->noContent());

Route::prefix("auth")->group(function (): void {
    Route::post("login", LoginController::class);
    Route::post("register", RegisterController::class);
    Route::post("logout", LogoutController::class)->middleware("auth:sanctum");
});

Route::middleware("auth:sanctum")->group(function (): void {
    Route::prefix("me")->group(function (): void {
        Route::get("/", UserController::class);

        Route::get("/classrooms", [ClassroomController::class, "index"]);
        Route::post("/classrooms/join", [MemberController::class, "join"]);
        Route::delete("/classrooms/{classroom}/exit", [MemberController::class, "exit"]);
        Route::get("/owned-classrooms", [ClassroomController::class, "ownedIndex"]);
    });

    Route::post("/classrooms", [ClassroomController::class, "store"]);
    Route::get("/classrooms/{classroom}", [ClassroomController::class, "show"]);
    Route::put("/classrooms/{classroom}", [ClassroomController::class, "update"]);
    Route::delete("/classrooms/{classroom}", [ClassroomController::class, "delete"]);
    Route::put("/classrooms/{classroom}/archive", [ClassroomController::class, "archive"]);
    Route::delete("/classrooms/{classroom}/archive", [ClassroomController::class, "unarchive"]);
    Route::put("/classrooms/{classroom}/joining", [ClassroomController::class, "enableJoining"]);
    Route::delete("/classrooms/{classroom}/joining", [ClassroomController::class, "disableJoining"]);
    Route::put("/classrooms/{classroom}/refresh-code", [ClassroomController::class, "refreshCode"]);

    Route::get("/classrooms/{classroom}/members", [MemberController::class, "index"]);
    Route::post("/classrooms/{classroom}/members", [MemberController::class, "add"]);
    Route::delete("/classrooms/{classroom}/members", [MemberController::class, "removeAll"]);
    Route::delete("/classrooms/{classroom}/members/{member}", [MemberController::class, "remove"]);

    Route::get("/classrooms/{classroom}/posts", [PostController::class, "index"]);
    Route::post("/classrooms/{classroom}/posts", [PostController::class, "store"]);
    Route::get("/posts/{post}", [PostController::class, "show"]);
    Route::put("/posts/{post}", [PostController::class, "update"]);
    Route::delete("/posts/{post}", [PostController::class, "delete"]);

    Route::get("/posts/{post}/comments", [CommentController::class, "indexForPost"]);
    Route::post("/posts/{post}/comments", [CommentController::class, "storeForPost"]);
    Route::get("/assignments/{assignment}/comments", [CommentController::class, "indexForAssignment"]);
    Route::post("/assignments/{assignment}/comments", [CommentController::class, "storeForAssignment"]);
    Route::get("/submissions/{submission}/comments", [CommentController::class, "indexForSubmission"]);
    Route::post("/submissions/{submission}/comments", [CommentController::class, "storeForSubmission"]);
    Route::get("/comments/{comment}", [CommentController::class, "show"]);
    Route::put("/comments/{comment}", [CommentController::class, "update"]);
    Route::delete("/comments/{comment}", [CommentController::class, "delete"]);

    Route::get("/classrooms/{classroom}/assignments", [AssignmentController::class, "index"]);
    Route::post("/classrooms/{classroom}/assignments", [AssignmentController::class, "store"]);
    Route::get("/assignments/{assignment}", [AssignmentController::class, "show"]);
    Route::put("/assignments/{assignment}", [AssignmentController::class, "update"]);
    Route::delete("/assignments/{assignment}", [AssignmentController::class, "delete"]);

    Route::get("/assignments/{assignment}/submissions", [SubmissionController::class, "index"]);
    Route::get("/submissions/{submission}", [SubmissionController::class, "show"]);
    Route::put("/submissions/{submission}/return", [SubmissionController::class, "return"]);
    Route::put("/submissions/{submission}/reclaim", [SubmissionController::class, "reclaim"]);
    Route::put("/submissions/{submission}/evaluate", [SubmissionController::class, "evaluate"]);
    Route::post("/submissions/{submission}/attachments", [SubmissionController::class, "attachFile"]);
    Route::delete("/submissions/{submission}/attachments/{attachment}", [SubmissionController::class, "detachFile"]);

    Route::get("/attachments", [AttachmentController::class, "index"]);
    Route::post("/attachments", [AttachmentController::class, "store"]);
    Route::get("/attachments/{attachment}", [AttachmentController::class, "show"]);
    Route::delete("/attachments/{attachment}", [AttachmentController::class, "delete"]);
});
