<?php

namespace App\UseCase\Auth;

use App\Domain\Auth\Logout as LogoutDomain;
use App\Models\User;
use App\UseCase\BaseUseCase;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class Logout extends BaseUseCase implements LogoutDomain
{
    /**
     * User to logout
     */
    protected User $user;

    public function __construct(
        User $user,
    ) {
        $this->user = $user;
    }

    public function handle(): void
    {
        try {
            $this->user?->tokens()->delete();
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
