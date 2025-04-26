<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request The login request containing email and password
     * @return JsonResponse
     */
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $existingUser = User::where('email', $data['email'])->first();

        if (!$existingUser || !Hash::check($data['password'], $existingUser->password))
            return response()->json(['message' => 'Invalid credentials.'], 401);

        $token = $existingUser->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
        ], 200);
    }
}
