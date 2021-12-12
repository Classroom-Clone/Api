<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Attachment\StoreRequest;
use App\Http\Resources\Attachment\AttachmentResource;
use App\Models\Attachment;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class AttachmentController extends Controller
{
    public function index(): JsonResource
    {
        return AttachmentResource::collection(Attachment::all());
    }

    public function download(Attachment $attachment): BinaryFileResponse
    {
        return response()->download(
            file: storage_path("app/{$attachment->path}"),
            name: $attachment->original,
            disposition: ResponseHeaderBag::DISPOSITION_INLINE,
        );
    }

    public function show(Attachment $attachment): JsonResource
    {
        return new AttachmentResource($attachment);
    }

    public function store(StoreRequest $request): JsonResource
    {
        $attachment = Attachment::query()->create($request->getAttachmentData());

        return new AttachmentResource($attachment);
    }

    public function delete(Attachment $attachment): Response
    {
        $attachment->delete();

        return response()->noContent();
    }
}
