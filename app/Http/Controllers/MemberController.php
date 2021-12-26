<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Classroom\JoinRequest;
use App\Http\Requests\Member\AddRequest;
use App\Http\Resources\Classroom\ClassroomResource;
use App\Http\Resources\Member\MemberCollection;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class MemberController extends Controller
{
    public function index(Request $request, Classroom $classroom): JsonResource
    {
        $members = $classroom->members()
            ->paginate($request->query("perPage"));

        return new MemberCollection($members);
    }

    public function join(JoinRequest $request): JsonResource
    {
        $classroom = $request->getClassroom();

        abort_if(!$classroom->allowJoin(), SymfonyResponse::HTTP_FORBIDDEN);

        $classroom->members()->syncWithoutDetaching($request->user());

        return new ClassroomResource($classroom);
    }

    public function exit(Request $request, Classroom $classroom): Response
    {
        $classroom->members()->detach($request->user());

        return response()->noContent();
    }

    public function add(AddRequest $request, Classroom $classroom): Response
    {
        $user = User::query()->find($request->user_id);

        $classroom->members()->syncWithoutDetaching($user);

        return response()->noContent();
    }

    public function remove(Classroom $classroom, User $member): Response
    {
        $classroom->members()->detach($member);

        return response()->noContent();
    }

    public function removeAll(Classroom $classroom): Response
    {
        $classroom->members()->detach();

        return response()->noContent();
    }
}
