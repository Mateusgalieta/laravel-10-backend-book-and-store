<?php

namespace App\UseCase\Auth;

use App\Domain\Auth\Login as LoginDomain;
use App\UseCase\BaseUseCase;
use App\UseCase\DTO\Auth\LoginDTO;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Throwable;

class Login extends BaseUseCase implements LoginDomain
{
    /**
     * DTO to login user
     */
    protected LoginDTO $params;

    public function __construct(
        LoginDTO $params,
    ) {
        $this->params = $params;
    }

    public function handle(): string
    {
        try {
            if (!auth()->attempt($this->params->toArray())) {
                return [
                    'success' => false,
                    'message' => 'Invalid Credentials',
                ];
            }

            return auth()->user()->createToken('accessToken')->plainTextToken;
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
