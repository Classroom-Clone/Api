<?php

declare(strict_types=1);

use App\Enums\SubmissionState;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create("submissions", function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Assignment::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string("state")->default(SubmissionState::ACTIVE->value);
            $table->integer("points")->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("submissions");
    }
};
