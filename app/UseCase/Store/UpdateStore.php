<?php

namespace App\UseCase\Store;

use App\Domain\Store\UpdateStore as UpdateStoreDomain;
use App\Models\Store;
use App\Repositories\StoreRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class UpdateStore extends BaseUseCase implements UpdateStoreDomain
{
    /**
     * Store id
     */
    protected int $storeId;

    /**
     * Content to update
     */
    protected array $data;

    public function __construct(
        int $storeId,
        array $data,
    ) {
        $this->storeId = $storeId;
        $this->data = $data;
    }

    public function handle(): Store
    {
        try {
            return $this->instance(
                StoreRepository::class,
            )->updateById($this->storeId, $this->data);
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
