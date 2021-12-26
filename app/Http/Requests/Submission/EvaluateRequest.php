<?php

declare(strict_types=1);

namespace App\Http\Requests\Submission;

use App\Models\Submission;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $points
 * @property Submission $submission
 */
class EvaluateRequest extends FormRequest
{
    public function rules(): array
    {
        $maxPoints = $this->submission->assignment->points;

        return [
            "points" => ["required", "integer", "max:${maxPoints}"],
        ];
    }

    public function getEvaluateData(): array
    {
        return [
            "points" => (int)$this->get("points"),
        ];
    }
}
