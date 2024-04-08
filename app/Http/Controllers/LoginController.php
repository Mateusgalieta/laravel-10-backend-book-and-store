<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\UseCase\Auth\Login;
use App\UseCase\DTO\Auth\LoginDTO;
use Illuminate\Http\JsonResponse;

class LoginController
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $params = new LoginDTO(
            $request->email,
            $request->password,
        );

        $useCase = (
            new Login($params)
        );

        $data = $useCase->handle();

        return response()->json([
            'success' => true,
            'access_token' => $data,
        ]);
    }
}
