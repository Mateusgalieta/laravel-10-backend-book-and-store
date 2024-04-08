<?php

namespace App\UseCase\Book;

use App\Domain\Book\DeleteBook as DeleteBookDomain;
use App\Repositories\BookRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class DeleteBook extends BaseUseCase implements DeleteBookDomain
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

    public function handle(): void
    {
        try {
            $this->instance(
                BookRepository::class,
            )->deleteById($this->bookId);
        } catch (Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'message' => "Book with ID $this->bookId cannot be deleted. Error: {$th->getMessage()}.",
                ], Response::HTTP_BAD_REQUEST)
            );
        }
    }
}
