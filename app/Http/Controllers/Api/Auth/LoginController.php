<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService
    )
    {}

    /**
     * Handle an incoming authentication request and return an authentication token.
     *
     * @param LoginRequest $request The login request containing email and password
     * @return JsonResponse The response containing the user's authentication token
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $loginDto = $request->toDTO();

        $token = $this->loginService->handle($loginDto);

        return response()->json([
            'token' => $token,
        ], 200);
    }
}
