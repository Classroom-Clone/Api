<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Assignment;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    public function indexForPost(Request $request, Post $post): JsonResource
    {
        $comments = $post->comments()
            ->paginate($request->query("perPage"));

        return new CommentCollection($comments);
    }

    public function indexForAssignment(Request $request, Assignment $assignment): JsonResource
    {
        $comments = $assignment->comments()
            ->paginate($request->query("perPage"));

        return new CommentCollection($comments);
    }

    public function indexForSubmission(Request $request, Submission $submission): JsonResource
    {
        $comments = $submission->comments()
            ->paginate($request->query("perPage"));

        return new CommentCollection($comments);
    }

    public function show(Comment $comment): JsonResource
    {
        return new CommentResource($comment);
    }

    public function storeForPost(StoreRequest $request, Post $post): JsonResource
    {
        $comment = $post->comments()->create($request->getCommentData());

        return new CommentResource($comment);
    }

    public function storeForAssignment(StoreRequest $request, Assignment $assignment): JsonResource
    {
        $comment = $assignment->comments()->create($request->getCommentData());

        return new CommentResource($comment);
    }

    public function storeForSubmission(StoreRequest $request, Submission $submission): JsonResource
    {
        $comment = $submission->comments()->create($request->getCommentData());

        return new CommentResource($comment);
    }

    public function update(UpdateRequest $request, Comment $comment): JsonResource
    {
        $comment->update($request->getCommentData());

        return new CommentResource($comment);
    }

    public function delete(Comment $comment): Response
    {
        $comment->delete();

        return response()->noContent();
    }
}
