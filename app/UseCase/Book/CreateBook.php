<?php

namespace App\UseCase\Book;

use App\Domain\Book\Create;
use App\Models\Book;
use App\Repositories\BookRepository;
use App\UseCase\BaseUseCase;
use App\UseCase\DTO\Book\CreateBookDTO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class CreateBook extends BaseUseCase implements Create
{
    /**
     * DTO to create Book
     */
    protected CreateBookDTO $params;

    public function __construct(
        CreateBookDTO $params,
    ) {
        $this->params = $params;
    }

    public function handle(): Book
    {
        try {
            return $this->instance(
                BookRepository::class,
            )->create($this->params->toArray());
        } catch (Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'errors' => $th->getMessage(),
                    'status' => false,
                ], Response::HTTP_UNPROCESSABLE_ENTITY)
            );
        }
    }
}
