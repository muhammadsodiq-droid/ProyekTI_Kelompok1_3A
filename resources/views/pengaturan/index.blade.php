@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Pengaturan</h2>

    {{-- Akun --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h3 class="text-lg font-semibold">Akun</h3>
        <p class="text-sm text-gray-500">Kelola profil dan password.</p>
        <form action="{{ route('settings.changePassword') }}" method="POST" class="mt-3">
            @csrf
            <div>
                <label>Password Lama</label>
                <input type="password" name="old_password" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Password Baru</label>
                <input type="password" name="new_password" class="border p-2 w-full" required>
            </div>
            <div>
                <label>Konfirmasi Password</label>
                <input type="password" name="new_password_confirmation" class="border p-2 w-full" required>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Ubah Password</button>
        </form>
    </div>

    {{-- Google --}}
    <div class="bg-white p-4 rounded shadow mb-4">
        <h3 class="text-lg font-semibold">Kaitkan Google</h3>
        @if($user->google_linked)
            <p class="text-sm">Terhubung sebagai <strong>{{ $user->google_email }}</strong></p>
            <form action="{{ route('settings.unlinkGoogle') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 text-white px-4 py-2 mt-2 rounded">Lepas Akun Google</button>
            </form>
        @else
            <p class="text-sm">Agar bisa login cepat dengan Google.</p>
            <a href="{{ url('/auth/google/redirect') }}" class="bg-green-500 text-white px-4 py-2 mt-2 rounded">Kaitkan Google</a>
        @endif
    </div>

    {{-- Logout --}}
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold">Lainnya</h3>
        <p class="text-sm">Keluar dari sesi saat ini.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 mt-2 rounded">Logout</button>
        </form>
    </div>
</div>
@endsection
