<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\UseCase\DTO\User\SignUpUserParams;
use App\UseCase\User\SignUpUser;
use Illuminate\Http\JsonResponse;

class SignUpController
{
    public function __invoke(SignUpRequest $request): JsonResponse
    {
        $params = new SignUpUserParams(
            $request->name,
            $request->email,
            $request->password,
        );

        $useCase = (
            new SignUpUser($params)
        );
        $useCase->handle();

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
        ]);
    }
}
