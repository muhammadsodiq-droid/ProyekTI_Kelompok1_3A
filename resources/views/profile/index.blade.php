@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card" style="max-width:860px;margin:0 auto;">
        <h3>Foto Profil</h3>
        <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px;">
            @if($user->photo)
                <img src="{{ asset('storage/profiles/'.$user->photo) }}" alt="Avatar" style="width:96px;height:96px;border-radius:50%;object-fit:cover;">
            @else
                <span>No Photo</span>
            @endif

            <form method="post" enctype="multipart/form-data" action="{{ route('profile.uploadPhoto') }}">
                @csrf
                <input type="file" name="photo" accept="image/*" onchange="this.form.submit()">
            </form>

            <form method="post" action="{{ route('profile.resetPhoto') }}">
                @csrf
                <button class="btn" type="submit">Reset foto profil</button>
            </form>
        </div>

        <h3>Data Akun</h3>
        <ul>
            <li><strong>Nama Lengkap:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
        </ul>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@endsection
