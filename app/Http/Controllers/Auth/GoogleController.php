<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/admin/login')->withErrors(['email' => 'Login with Google failed.']);
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => Hash::make(str()->random(24)), // Create a random password
                'role' => 'user',
            ]);

            Auth::login($user);
        }

        return redirect('/admin');
    }
}
