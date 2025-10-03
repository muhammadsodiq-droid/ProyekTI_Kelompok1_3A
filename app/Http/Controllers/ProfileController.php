<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // pastikan model User ada

class ProfileController extends Controller
{
    // Tampilkan halaman profil
    public function show()
    {
        $user = Auth::user(); // ambil user yang login

        return view('profile.index', compact('user'));
    }

    // Update profil (email, biodata dll)
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'email' => $request->email,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    // Upload foto profil
    public function uploadPhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $file = $request->file('photo');
        $filename = 'photo_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profiles', $filename, 'public');

        // hapus foto lama kalau ada
        if ($user->photo) {
            \Storage::disk('public')->delete('profiles/' . $user->photo);
        }

        $user->update([
            'photo' => $filename,
        ]);

        return redirect()->route('profile.show')->with('success', 'Foto profil diperbarui.');
    }

    // Reset foto profil
    public function resetPhoto()
    {
        $user = Auth::user();

        if ($user->photo) {
            \Storage::disk('public')->delete('profiles/' . $user->photo);
            $user->update(['photo' => null]);
        }

        return redirect()->route('profile.show')->with('success', 'Foto profil direset.');
    }
}
