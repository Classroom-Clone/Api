<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Models\Classroom;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class PostController extends Controller
{
    public function index(Request $request, Classroom $classroom): JsonResource
    {
        $members = $classroom->posts()
            ->paginate($request->query("perPage"));

        return new PostCollection($members);
    }

    public function show(Post $post): JsonResource
    {
        return new PostResource($post);
    }

    public function store(StoreRequest $request, Classroom $classroom): JsonResource
    {
        /** @var Post $post */
        $post = $classroom->posts()->create($request->getPostData());

        $post->links()->createMany($request->getLinks());

        return new PostResource($post);
    }

    public function update(UpdateRequest $request, Post $post): JsonResource
    {
        $post->update($request->getPostData());

        $post->links()->delete();
        $post->links()->createMany($request->getLinks());

        return new PostResource($post);
    }

    public function delete(Post $post): Response
    {
        $post->delete();

        return response()->noContent();
    }
}
