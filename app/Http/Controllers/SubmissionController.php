<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SubmissionState;
use App\Http\Requests\Submission\EvaluateRequest;
use App\Http\Resources\Submission\SubmissionCollection;
use App\Http\Resources\Submission\SubmissionResource;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionController extends Controller
{
    public function index(Request $request, Assignment $assignment): JsonResource
    {
        $members = $assignment->submissions()
            ->paginate($request->query("perPage"));

        return new SubmissionCollection($members);
    }

    public function show(Submission $submission): JsonResource
    {
        return new SubmissionResource($submission);
    }

    public function return(Submission $submission): JsonResource
    {
        $submission->changeStateTo(SubmissionState::RETURNED);

        return new SubmissionResource($submission);
    }

    public function reclaim(Submission $submission): JsonResource
    {
        $submission->changeStateTo(SubmissionState::RECLAIMED);

        return new SubmissionResource($submission);
    }

    public function evaluate(EvaluateRequest $request, Submission $submission): JsonResource
    {
        $submission->update($request->getEvaluateData());
        $submission->changeStateTo(SubmissionState::EVALUATED);

        return new SubmissionResource($submission);
    }
}
