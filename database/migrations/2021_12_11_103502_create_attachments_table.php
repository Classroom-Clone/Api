<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("attachments", function (Blueprint $table): void {
            $table->uuid("id")->primary();
            $table->string("original");
            $table->string("mime_type");
            $table->string("path");
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->nullableMorphs("attachmentable");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("attachments");
    }
};
