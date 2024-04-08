<?php

namespace App\UseCase;

use App\Domain\Detach as DetachDomain;
use App\Repositories\DetachRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class Detach extends BaseUseCase implements DetachDomain
{
    /**
     * Book Id
     */
    protected int $bookId;

    /**
     * Store Id
     */
    protected int $storeId;

    public function __construct(
        int $bookId,
        int $storeId,
    ) {
        $this->bookId = $bookId;
        $this->storeId = $storeId;
    }

    public function handle(): void
    {
        try {
            $this->instance(
                DetachRepository::class,
            )->detach($this->bookId, $this->storeId);
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
