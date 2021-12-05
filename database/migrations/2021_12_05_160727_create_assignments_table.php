<?php

declare(strict_types=1);

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("assignments", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Classroom::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string("title");
            $table->text("content")->nullable();
            $table->integer("points")->nullable();
            $table->dateTime("due_date");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("assignments");
    }
};
