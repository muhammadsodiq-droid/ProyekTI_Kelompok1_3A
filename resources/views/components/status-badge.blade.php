@props(['label' => '', 'kind' => 'wait'])
@php
  $map = ['ok' => '✅', 'bad' => '⛔', 'wait' => '⏳'];
  $icon = $map[$kind] ?? '⏳';
  $bg = [
    'ok' => 'background:#dcfce7;color:#14532d;',
    'bad' => 'background:#fee2e2;color:#7f1d1d;',
    'wait' => 'background:#f1f5f9;color:#0f172a;',
  ][$kind] ?? 'background:#f1f5f9;color:#0f172a;';
@endphp
<span style="display:inline-flex;align-items:center;gap:6px;padding:2px 8px;border-radius:999px;{{ $bg }}">
  <span>{{ $icon }}</span> <span>{{ $label }}</span>
</span>

@php
  $badge = function (?string $s) {
      $s = strtolower(trim((string)$s));
      if (in_array($s, ['tervalidasi','disetujui','approve','approved','valid'])) return ['tervalidasi','ok'];
      if (in_array($s, ['revisi','ditolak','reject','rejected','invalid'])) return ['perlu revisi','bad'];
      return ['menunggu validasi','wait'];
  };
@endphp
