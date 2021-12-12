<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Attachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AttachmentFactory extends Factory
{
    protected $model = Attachment::class;

    public function definition(): array
    {
        $ext = $this->faker->randomElement(["jpg", "jpeg", "pdf", "docx", "zip"]);
        $uuid = Str::uuid()->toString();
        $file = UploadedFile::fake()->create(Str::random(24) . ".{$ext}");

        return [
            "id" => $uuid,
            "path" => $file->storeAs("attachments/{$uuid}", $file->getClientOriginalName()),
            "original" => $file->getClientOriginalName(),
            "mime_type" => $file->getClientMimeType(),
            "user_id" => User::factory(),
        ];
    }

    public function forRandomUser(): Factory
    {
        return $this->state(
            fn() => [
                "user_id" => User::query()->inRandomOrder()->first()->id,
            ],
        );
    }
}
