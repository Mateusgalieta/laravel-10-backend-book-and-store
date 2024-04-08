<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachRequest;
use App\UseCase\Attach;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AttachController
{
    public function __invoke(AttachRequest $request): JsonResponse
    {
        $useCase = (
            new Attach($request->book_id, $request->store_id)
        );
        $useCase->handle();

        return response()->json([
            'message' => 'Book and Store Linked sucessfully',
        ], Response::HTTP_CREATED);
    }
}
