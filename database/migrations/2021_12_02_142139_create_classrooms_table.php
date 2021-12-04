<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("classrooms", function (Blueprint $table): void {
            $table->id();
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("accent_color");
            $table->string("invite_code");
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("classrooms");
    }
};
