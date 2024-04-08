<?php

namespace App\UseCase\Book;

use App\Domain\Book\UpdateBook as UpdateBookDomain;
use App\Models\Book;
use App\Repositories\BookRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class UpdateBook extends BaseUseCase implements UpdateBookDomain
{
    /**
     * Book id
     */
    protected int $bookId;

    /**
     * Content to update
     */
    protected array $data;

    public function __construct(
        int $bookId,
        array $data,
    ) {
        $this->bookId = $bookId;
        $this->data = $data;
    }

    public function handle(): Book
    {
        try {
            return $this->instance(
                BookRepository::class,
            )->updateById($this->bookId, $this->data);
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
