@extends('layouts.app')

@section('content')
<style>
  .card{border:1px solid #eee;border-radius:12px;padding:12px;margin:12px 0}
  .section-title{margin:0 0 6px 0}
  .progress-steps{display:flex;gap:6px;height:12px;border-radius:999px;background:#f1f5f9;padding:4px}
  .progress-steps span{flex:1;border-radius:999px;background:#e5e7eb}
  .progress-steps span.pending{background:#111}
  .progress-steps span.ok{background:linear-gradient(135deg,#22c55e 0%,#a7f3d0 100%)}
  .btn{display:inline-flex;align-items:center;gap:6px;background:#2563eb;color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none}
  .btn.secondary{background:#111;color:#fff}
  .btn.inline{gap:8px;flex-wrap:wrap}
  .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-top:12px}
  .alert{background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:10px;margin:8px 0}
  .alert-success{background:#ecfdf5;border-color:#bbf7d0}
  .alert-error{background:#fee2e2;border-color:#fecaca}
  .modal-backdrop{position:fixed;inset:0;background:#0005;display:flex;align-items:center;justify-content:center}
  .modal{background:#fff;border-radius:12px;padding:16px;max-width:420px;width:100%;box-shadow:0 10px 30px #0003}
  .modal .modal-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:12px}
  .text-sm{font-size:12px;color:#555}
  .file-btn{display:inline-flex;align-items:center;gap:8px;border:1px dashed #9ca3af;border-radius:10px;padding:8px 10px;cursor:pointer}
  .file-btn input[type=file]{display:none}
</style>

@php
  // Helper untuk badge status dari string
  $badge = function (?string $s) {
      $s = strtolower(trim((string)$s));
      if (in_array($s, ['tervalidasi','disetujui','approve','approved','valid'])) return ['tervalidasi','ok'];
      if (in_array($s, ['revisi','ditolak','reject','rejected','invalid'])) return ['perlu revisi','bad'];
      return ['menunggu validasi','wait'];
  };

  $kUp = (bool)($khs['file_path'] ?? null);
  $sUp = (bool)($surat['file_path'] ?? null);
  $lUp = (bool)($lap['file_path'] ?? null);

  $kCls = $kUp ? (strtolower($khs['status_validasi'] ?? '') === 'tervalidasi' ? 'ok' : 'pending') : '';
  $sCls = $sUp ? (strtolower($surat['status_validasi'] ?? '') === 'tervalidasi' ? 'ok' : 'pending') : '';
  $lCls = $lUp ? (strtolower($lap['status_validasi'] ?? '') === 'tervalidasi' ? 'ok' : 'pending') : '';
@endphp

<div class="card">
  <h3 class="section-title">Pemberkasan PKL</h3>

  @if ($okCount === 3)
    <div class="alert alert-success">Selamat, berkasmu telah selesai dan tervalidasi dengan sempurna!</div>
  @else
    <div class="alert">Silakan lengkapi berkas PKL-mu. Pastikan setiap dokumen berstatus <em>tervalidasi</em>.</div>
  @endif

  <p class="text-sm">Progress: <strong>({{ $okCount }}/3)</strong></p>

  <div class="progress-steps">
    <span class="{{ $kCls }}" title="KHS"></span>
    <span class="{{ $sCls }}" title="Surat Balasan"></span>
    <span class="{{ $lCls }}" title="Laporan PKL"></span>
  </div>
  <p class="text-sm">KHS • Surat Balasan • Laporan</p>
</div>

{{-- Step 1 --}}
<div class="card step">
  <h3 class="section-title">Step 1: Unggah KHS</h3>

  @if (!$biodataLengkap)
    <p class="text-sm">
      <x-status-badge label="Biodata belum lengkap (IPK wajib diisi)" kind="bad"/>
    </p>
    <a class="btn" href="{{ route('profile.show') }}">Lengkapi Biodata</a>
  @else
    @php [$label,$kind] = $badge($khs['status_validasi'] ?? null); @endphp
    <p class="text-sm">
      Status: <x-status-badge :label="$label" :kind="$kind"/>
    </p>

    @if ($kUp)
      <p class="text-sm">File: <a href="{{ $khs['file_path'] }}" target="_blank">Lihat</a></p>
    @endif

    <div class="text-sm">File KHS (PDF/JPG/PNG)</div>
    <div class="btn inline">
      <label class="file-btn">
        <span class="file-text">{{ $kUp ? 'Ganti File' : 'Pilih file' }}</span> 📤
        <input id="khs_file" type="file" name="khs_file" data-action="upload_khs">
      </label>

      @if ($kUp)
        <button class="btn secondary" data-action="delete_khs">🗑️ Hapus</button>
      @endif
    </div>
  @endif
</div>

{{-- Step 2 --}}
<div class="card step">
  <h3 class="section-title">Step 2: Unggah Surat Balasan Mitra/Instansi</h3>
  @php [$label,$kind] = $badge($surat['status_validasi'] ?? null); @endphp
  <p class="text-sm">Status: <x-status-badge :label="$label" :kind="$kind"/></p>

  @if ($sUp)
    <p class="text-sm">File: <a href="{{ $surat['file_path'] }}" target="_blank">Lihat</a></p>
    <p class="text-sm">
      Mitra:
      @if (!empty($surat['mitra_id']))
        {{ collect($mitras)->firstWhere('id',$surat['mitra_id'])['nama'] ?? '-' }}
      @else
        {{ $surat['mitra_nama_custom'] ?? '-' }}
      @endif
    </p>
  @endif

  <div class="form-group">
    <label class="text-sm">Pilih Mitra/Instansi (opsional)</label>
    <select style="padding:6px 8px;border-radius:8px;border:1px solid #ddd;" id="mitra_select">
      <option value="">-- pilih dari daftar --</option>
      @foreach ($mitras as $m)
        <option value="{{ $m['id'] }}">{{ $m['nama'] }}</option>
      @endforeach
    </select>
    <p class="text-sm">Atau tulis manual jika tidak ada di daftar.</p>
  </div>

  <div class="form-group">
    <label class="text-sm">Nama mitra (custom)</label>
    <input type="text" id="mitra_custom" placeholder="Nama perusahaan bila tidak ada di daftar"
           style="padding:6px 8px;border-radius:8px;border:1px solid #ddd;width:100%;max-width:420px;">
  </div>

  <div class="btn inline">
    <label class="file-btn">
      <span class="file-text">{{ $sUp ? 'Ganti File' : 'Pilih file' }}</span> 📤
      <input id="surat_file" type="file" data-action="upload_surat">
    </label>
    @if ($sUp)
      <button class="btn secondary" data-action="delete_surat">🗑️ Hapus</button>
    @endif
  </div>
</div>

{{-- Step 3 --}}
<div class="card step">
  <h3 class="section-title">Step 3: Unggah Laporan PKL</h3>
  @php [$label,$kind] = $badge($lap['status_validasi'] ?? null); @endphp
  <p class="text-sm">Status: <x-status-badge :label="$label" :kind="$kind"/></p>

  @if ($lUp)
    <p class="text-sm">File: <a href="{{ $lap['file_path'] }}" target="_blank">Lihat</a></p>
  @endif

  <div class="btn inline">
    <label class="file-btn">
      <span class="file-text">{{ $lUp ? 'Ganti File' : 'Pilih file' }}</span> 📤
      <input id="laporan_file" type="file" data-action="upload_laporan">
    </label>
    @if ($lUp)
      <button class="btn secondary" data-action="delete_laporan">🗑️ Hapus</button>
    @endif
  </div>
</div>

{{-- Modal dummy pilih mitra (simulasi ?pick_mitra=ID) --}}
@if ($pickMitraModal)
  <div class="modal-backdrop show">
    <div class="modal" role="dialog" aria-modal="true">
      <h3>Konfirmasi Mitra</h3>
      <p>Anda yakin ingin memilih <strong>{{ $pickMitraModal['nama'] }}</strong> ini? Jika ya, akan diterapkan di Step 2.</p>
      <div class="modal-actions">
        <a class="btn secondary" href="{{ route('pemberkasan.index') }}">Batal</a>
        <button class="btn" onclick="alert('Nanti ini kirim POST confirm_pick_mitra')">Ya, pilih</button>
      </div>
    </div>
  </div>
@endif

<script>
  // Placeholder “auto-upload”: sekarang cuma alert, nanti ganti submit form POST
  document.querySelectorAll('input[type="file"][data-action]').forEach(function (inp) {
    const label = inp.closest('label.file-btn')?.querySelector('.file-text');
    inp.addEventListener('change', function () {
      if (inp.files && inp.files.length) {
        if (label) label.textContent = 'Ganti File';
        alert('Dummy upload: ' + inp.getAttribute('data-action') + ' — nanti dihubungkan ke route POST');
        // TODO: ganti dengan submit ke route POST saat DB siap
      }
    });
  });

  document.querySelectorAll('button[data-action^="delete_"]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (confirm('Hapus dokumen terakhir?')) {
        alert('Dummy delete: ' + btn.getAttribute('data-action') + ' — nanti dihubungkan ke route POST');
      }
    });
  });
</script>
@endsection
