<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTOs\Auth\RegisterDTO;
use App\Models\User;
use App\Notifications\NewUserWelcomeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterService
{
    /**
     * Handle the registration of a new user.
     *
     * @param RegisterDTO $registerDTO The data transfer object containing user data
     * @return void
     */
    public function handle(RegisterDTO $registerDTO): void
    {
        //Generate a random password if not provided
        $password = $registerDTO->password ?? Str::password(12, letters: true, numbers: true, symbols: false);

        $user = User::create([
            'name' => $registerDTO->name,
            'email' => $registerDTO->email,
            'password' => Hash::make($password),
        ]);

        //Assigm the role to the user
        $user->assignRole($registerDTO->role);

        // Send a welcome email to user email
        $user->notify(new NewUserWelcomeNotification($password));
    }
}
