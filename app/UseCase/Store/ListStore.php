<?php

namespace App\UseCase\Store;

use App\Domain\Store\ListStore as ListStoreDomain;
use App\Repositories\StoreRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;

class ListStore extends BaseUseCase implements ListStoreDomain
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
                StoreRepository::class,
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
