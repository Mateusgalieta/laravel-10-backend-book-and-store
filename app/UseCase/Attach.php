<?php

namespace App\UseCase;

use App\Domain\Attach as AttachDomain;
use App\Repositories\AttachRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class Attach extends BaseUseCase implements AttachDomain
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
                AttachRepository::class,
            )->attach($this->bookId, $this->storeId);
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
