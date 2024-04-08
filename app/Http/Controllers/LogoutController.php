<?php

namespace App\Http\Controllers;

use App\UseCase\Auth\Logout;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController
{
    public function __invoke(Request $request): JsonResponse
    {
        $useCase = (
            new Logout(auth()->user())
        );
        $useCase->handle();

        return response()->json([
            'success' => true,
            'messsage' => 'User logout successfully',
        ]);
    }
}
