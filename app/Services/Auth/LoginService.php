<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTOs\Auth\LoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
/**
     * Authenticate a user and generate an authentication token.
     *
     * @param LoginDTO $loginDTO The data transfer object containing user login credentials
     * @return string The user's authentication token
     * @throws ValidationException If the provided credentials are invalid
     */
    public function handle(LoginDTO $loginDTO): string
    {
        // Check if user existss
        $existingUser = User::where('email', $loginDTO->email)->first();

        if (!$existingUser || !Hash::check($loginDTO->password, $existingUser->password))
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);

        // Generate auth token
        $token = $existingUser->createToken('auth_token')->plainTextToken;

        return $token;
    }
}
