<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Classroom\StoreRequest;
use App\Http\Requests\Classroom\UpdateRequest;
use App\Http\Resources\Classroom\ClassroomCollection;
use App\Http\Resources\Classroom\ClassroomResource;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ClassroomController extends Controller
{
    public function ownedIndex(Request $request): JsonResource
    {
        $classrooms = $request->user()
            ->ownedClassrooms()
            ->paginate($request->query("perPage"));

        return new ClassroomCollection($classrooms);
    }

    public function store(StoreRequest $request): JsonResource
    {
        $classroom = $request->user()
            ->ownedClassrooms()
            ->create($request->validated());

        return new ClassroomResource($classroom);
    }

    public function update(UpdateRequest $request, Classroom $classroom): JsonResource
    {
        $classroom->update($request->validated());

        return new ClassroomResource($classroom);
    }

    public function delete(Classroom $classroom): Response
    {
        $classroom->delete();

        return response()->noContent();
    }

    public function archive(Classroom $classroom): JsonResource
    {
        $classroom->archive();

        return new ClassroomResource($classroom);
    }

    public function unarchive(Classroom $classroom): JsonResource
    {
        $classroom->unarchive();

        return new ClassroomResource($classroom);
    }
}
