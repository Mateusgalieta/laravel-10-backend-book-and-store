<?php

namespace App\UseCase\Book;

use App\Domain\Book\ListBook as ListBookDomain;
use App\Repositories\BookRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class ListBook extends BaseUseCase implements ListBookDomain
{
    /**
     * PerPage
     */
    protected ?int $perPage;

    /**
     * Page
     */
    protected ?int $page;

    public function __construct(
        ?int $perPage,
        ?int $page,
    ) {
        $this->perPage = $perPage;
        $this->page = $page;
    }

    public function handle(): LengthAwarePaginator
    {
        try {
            return $this->instance(
                BookRepository::class,
            )->listAll($this->perPage, $this->page);
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
