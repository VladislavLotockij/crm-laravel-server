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

        $password = $data['password'] ?? Str::password(12, letters: true, numbers: true, symbols: false);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole($data['role']);

        $user->notify(new NewUserWelcomeNotification($password));

        return response()->json([
            'message' => 'User created successfully. Welcome email sent.'
        ], 201);
    }
}
