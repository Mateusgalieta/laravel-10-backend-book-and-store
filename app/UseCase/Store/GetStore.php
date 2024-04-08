<?php

namespace App\UseCase\Store;

use App\Domain\Store\GetStore as GetStoreDomain;
use App\Models\Store;
use App\Repositories\StoreRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class GetStore extends BaseUseCase implements GetStoreDomain
{
    /**
     * Store id
     */
    protected int $storeId;

    public function __construct(
        int $storeId,
    ) {
        $this->storeId = $storeId;
    }

    public function handle(): ?Store
    {
        try {
            return $this->instance(
                StoreRepository::class,
            )->findById($this->storeId);
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
