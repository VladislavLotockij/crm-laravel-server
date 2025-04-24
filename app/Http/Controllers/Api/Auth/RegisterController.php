<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\NewUserWelcomeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $data = $request->validated();
        $temporaryPassword = Str::random(12);

        //TODO: add a role for user

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($temporaryPassword),
        ]);

        $user->notify(new NewUserWelcomeNotification(($temporaryPassword)));

        return response()->json(['message' => 'User created successfully. Welcome email sent.'], 201);
    }
}
