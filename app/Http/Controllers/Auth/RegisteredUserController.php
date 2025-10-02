<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaProfile;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nim' => ['required', 'string', 'max:50', 'unique:mahasiswa_profiles,nim'],
            'prodi' => ['required', 'string', 'max:100'],
            'semester' => ['required', 'integer', 'min:1'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa', // Default role
        ]);

        MahasiswaProfile::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'semester' => $request->semester,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/admin'); // Redirect to filament admin panel
    }
}
