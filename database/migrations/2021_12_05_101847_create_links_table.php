<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("links", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Post::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string("name")->nullable();
            $table->string("url");
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("links");
    }
};
