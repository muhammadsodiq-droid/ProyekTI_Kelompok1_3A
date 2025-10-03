@extends('layouts.app')

@section('content')
<div class="hero">
  <h3>Hai, {{ e($user->name) }} <span class="muted">(mahasiswa)</span></h3>

  <div style="display:flex;align-items:center;gap:12px;margin:8px 0">
    {{-- Avatar dummy --}}
    <div style="width:40px;height:40px;border-radius:9999px;background:#ddd"></div>
    <span class="count-pill">{{ $count }}/3 berkas</span>
  </div>

  <div class="progress" style="max-width:320px;">
    <span style="width:{{ $pct }}%"></span>
  </div>
</div>

<div class="grid">
  <a class="card" href="{{ route('pemberkasan.index') }}">
    <strong>📄 Pemberkasan</strong>
    <p class="muted">Kelola KHS, Surat Balasan, Laporan PKL</p>
  </a>
  <a class="card" href="{{ route('mitra.index') }}">
    <strong>💼 Mitra/Instansi</strong>
    <p class="muted">Pilih atau cek mitra</p>
  </a>
  <a class="card" href="{{ route('profile.show') }}">
    <strong>👤 Profile</strong>
    <p class="muted">Biodata & foto profil</p>
  </a>
  <a class="card" href="{{ route('settings.index') }}">
    <strong>⚙️ Pengaturan</strong>
    <p class="muted">Password & integrasi</p>
  </a>
</div>
@endsection
