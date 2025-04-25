<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();

        $existingUser = User::where('email', $data['email'])->first();

        if (!$existingUser || Hash::check($data['password'], $existingUser->password))
            return response()->json(['message' => 'Invalid credentials.'], 401);

        $existingUser->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $existingUser->createToken('auth_token')->plainTextToken,
        ], 200);
    }
}
