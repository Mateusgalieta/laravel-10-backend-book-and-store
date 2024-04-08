<?php

namespace App\UseCase\Store;

use App\Domain\Store\CreateStore as CreateStoreDomain;
use App\Models\Store;
use App\Repositories\StoreRepository;
use App\UseCase\BaseUseCase;
use App\UseCase\DTO\Store\CreateStoreDTO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class CreateStore extends BaseUseCase implements CreateStoreDomain
{
    /**
     * DTO to create Store
     */
    protected CreateStoreDTO $params;

    public function __construct(
        CreateStoreDTO $params,
    ) {
        $this->params = $params;
    }

    public function handle(): Store
    {
        try {
            return $this->instance(
                StoreRepository::class,
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
