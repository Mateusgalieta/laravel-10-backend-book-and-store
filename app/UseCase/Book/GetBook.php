<?php

namespace App\UseCase\Book;

use App\Domain\Book\GetBook as GetBookDomain;
use App\Models\Book;
use App\Repositories\BookRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class GetBook extends BaseUseCase implements GetBookDomain
{
    /**
     * Book id
     */
    protected int $bookId;

    public function __construct(
        int $bookId,
    ) {
        $this->bookId = $bookId;
    }

    public function handle(): ?Book
    {
        try {
            return $this->instance(
                BookRepository::class,
            )->findById($this->bookId);
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
