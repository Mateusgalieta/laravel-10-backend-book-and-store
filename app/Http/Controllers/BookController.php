<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Book\BookResource;
use App\UseCase\Book\CreateBook;
use App\UseCase\Book\DeleteBook;
use App\UseCase\Book\GetBook;
use App\UseCase\Book\ListBook;
use App\UseCase\Book\UpdateBook;
use App\UseCase\DTO\Book\CreateBookDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController
{
    /**
     * Create Book
     *
     * POST /api/book
     */
    public function create(CreateBookRequest $request): JsonResponse
    {
        $params = new CreateBookDTO(
            $request->name,
            $request->isbn,
            $request->value,
        );

        $useCase = (
            new CreateBook($params)
        );
        $data = $useCase->handle();

        return response()->json(
            new BookResource(
                $data,
            ),
            Response::HTTP_CREATED
        );
    }

    /**
     * Return Book List
     *
     * GET /api/book
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page') ?? 1;

        $useCase = (
            new ListBook($perPage, $page)
        );
        $data = $useCase->handle();

        return new BookCollection($data);
    }

    /**
     * Return one Book
     *
     * GET /api/book/{id}
     */
    public function show(int $id): JsonResponse
    {
        $useCase = (
            new GetBook($id)
        );
        $data = $useCase->handle();

        if (is_null($data)) {
            return response()->json([
                'message' => "Book with ID $id was not found.",
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new BookResource($data));
    }

    /**
     * Update Book
     *
     * PUT /api/book/{id}
     */
    public function update(int $id, UpdateBookRequest $request): JsonResponse
    {
        $useCase = (
            new UpdateBook($id, $request->all())
        );
        $data = $useCase->handle();

        return response()->json(new BookResource($data));
    }

    /**
     * Delete Book
     *
     * DELETE /api/book/{id}
     */
    public function delete(int $id): JsonResponse
    {
        (new DeleteBook($id))->handle();

        return response()->json([
            'message' => "Book with ID $id deleted successfully.",
        ]);
    }
}
