<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\NewUserWelcomeNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Handle user registration.
     *
     * @param RegisterRequest $request The registration request containing user data
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        // If password is not provided, generate a random 12-character password
        // containing letters and numbers but no symbols (for user experience)
        $password = $data['password'] ?? Str::password(12, letters: true, numbers: true, symbols: false);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
        ]);

        // Assign specified role to the user
        $user->assignRole($data['role']);

        // Send welcome email with login credentials to the new user
        $user->notify(new NewUserWelcomeNotification($password));

        return response()->json([
            'message' => 'User created successfully. Welcome email sent.'
        ], 201);
    }
}
