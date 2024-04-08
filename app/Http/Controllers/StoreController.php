<?php

namespace App\Http\Controllers;

use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Http\Resources\Store\StoreCollection;
use App\Http\Resources\Store\StoreResource;
use App\UseCase\DTO\Store\CreateStoreDTO;
use App\UseCase\Store\CreateStore;
use App\UseCase\Store\DeleteStore;
use App\UseCase\Store\GetStore;
use App\UseCase\Store\ListStore;
use App\UseCase\Store\UpdateStore;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoreController
{
    /**
     * Create Store
     *
     * POST /api/store
     */
    public function create(CreateStoreRequest $request): JsonResponse
    {
        $params = new CreateStoreDTO(
            $request->name,
            $request->address,
            $request->active,
        );

        $useCase = (
            new CreateStore($params)
        );
        $data = $useCase->handle();

        return response()->json(
            new StoreResource(
                $data,
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Return Store List
     *
     * GET /api/store
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page') ?? 1;

        $useCase = (
            new ListStore($perPage, $page)
        );
        $data = $useCase->handle();

        return new StoreCollection($data);
    }

    /**
     * Return one Store
     *
     * GET /api/store/{id}
     */
    public function show(int $id): JsonResponse
    {
        $useCase = (
            new GetStore($id)
        );
        $data = $useCase->handle();

        if (is_null($data)) {
            return response()->json([
                'message' => "Store with ID $id was not found.",
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new StoreResource($data));
    }

    /**
     * Update Store
     *
     * PUT /api/store/{id}
     */
    public function update(int $id, UpdateStoreRequest $request): JsonResponse
    {
        $useCase = (
            new UpdateStore($id, $request->all())
        );
        $data = $useCase->handle();

        return response()->json(new StoreResource($data));
    }

    /**
     * Delete Store
     *
     * DELETE /api/store/{id}
     */
    public function delete(int $id): JsonResponse
    {
        (new DeleteStore($id))->handle();

        return response()->json([
            'message' => "Store with ID $id deleted successfully.",
        ]);
    }
}
