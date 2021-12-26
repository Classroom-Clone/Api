<?php

declare(strict_types=1);

use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

Route::get("attachments/{attachment}/download", [AttachmentController::class, "download"])
    ->middleware("signed")
    ->name("attachment.download");
