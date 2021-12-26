<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\SyncAttachmentsAction;
use App\Http\Requests\Assignment\StoreRequest;
use App\Http\Requests\Assignment\UpdateRequest;
use App\Http\Resources\Assignment\AssignmentCollection;
use App\Http\Resources\Assignment\AssignmentResource;
use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AssignmentController extends Controller
{
    public function index(Request $request, Classroom $classroom): JsonResource
    {
        $members = $classroom->assignments()
            ->paginate($request->query("perPage"));

        return new AssignmentCollection($members);
    }

    public function show(Assignment $assignment): JsonResource
    {
        return new AssignmentResource($assignment);
    }

    public function store(StoreRequest $request, Classroom $classroom): JsonResource
    {
        $assignment = $classroom->assignments()->create($request->getAssignmentData());
        $assignment->attachments()->saveMany($request->getAttachments());

        return new AssignmentResource($assignment);
    }

    public function update(UpdateRequest $request, SyncAttachmentsAction $syncAttachments, Assignment $assignment): JsonResource
    {
        $assignment->update($request->getAssignmentData());

        $syncAttachments->execute($assignment, $request->getAttachments());
        $assignment->refresh();

        return new AssignmentResource($assignment);
    }

    public function delete(Assignment $assignment): Response
    {
        $assignment->delete();

        return response()->noContent();
    }
}
