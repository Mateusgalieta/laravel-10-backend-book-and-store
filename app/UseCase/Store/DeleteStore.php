<?php

namespace App\UseCase\Store;

use App\Domain\Store\DeleteStore as DeleteStoreDomain;
use App\Repositories\StoreRepository;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class DeleteStore extends BaseUseCase implements DeleteStoreDomain
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

    public function handle(): void
    {
        try {
            $this->instance(
                StoreRepository::class,
            )->deleteById($this->storeId);
        } catch (Throwable $th) {
            throw new HttpResponseException(
                response()->json([
                    'message' => "Store with ID $this->storeId cannot be deleted. Error: {$th->getMessage()}.",
                ], Response::HTTP_BAD_REQUEST)
            );
        }
    }
}
