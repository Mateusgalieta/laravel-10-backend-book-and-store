<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetachRequest;
use App\UseCase\Detach;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DetachController
{
    public function __invoke(DetachRequest $request): JsonResponse
    {
        $useCase = (
            new Detach($request->book_id, $request->store_id)
        );
        $useCase->handle();

        return response()->json([
            'message' => 'Book and Store unlinked sucessfully',
        ], Response::HTTP_CREATED);
    }
}
