<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(
        protected RegisterService $registerService,
    ) {}
    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request The registration request containing user data
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $registerDTO = $request->toDTO();

        $this->registerService->handle($registerDTO);

        return response()->json([
            'message' => 'User created successfully. Welcome email sent.'
        ], 201);
    }
}
