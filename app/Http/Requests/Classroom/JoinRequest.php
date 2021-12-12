<?php

declare(strict_types=1);

namespace App\Http\Requests\Classroom;

use App\Models\Classroom;
use Illuminate\Foundation\Http\FormRequest;

class JoinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "join_code" => ["required", "exists:classrooms,join_code"],
        ];
    }

    public function getClassroom(): Classroom
    {
        $classroom = Classroom::query()
            ->where("join_code", $this->get("join_code"))
            ->first();

        return $classroom;
    }
}
