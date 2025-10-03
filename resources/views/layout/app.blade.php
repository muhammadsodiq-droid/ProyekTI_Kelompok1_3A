<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? config('app.name', 'SIPP PKL') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;margin:0;color:#111}
    .container{max-width:1000px;margin:0 auto;padding:16px}
    header, footer{border-bottom:1px solid #eee}
    footer{border-top:1px solid #eee;border-bottom:none;color:#666;font-size:12px}
    .hero h3{margin:8px 0}
    .btn{display:inline-flex;align-items:center;gap:8px;background:#2563eb;color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none}
    .btn-sm{padding:6px 10px;font-size:12px}
    .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-top:16px}
    .card{display:block;border:1px solid #eee;border-radius:12px;padding:12px;text-decoration:none;color:inherit}
    .card strong{display:flex;align-items:center;gap:8px;margin-bottom:6px}
    .count-pill{background:#f3f4f6;border-radius:999px;padding:4px 10px;font-size:12px}
    .progress{height:8px;background:#eee;border-radius:9999px;overflow:hidden}
    .progress > span{display:block;height:100%;background:#3b82f6}
    nav a{margin-right:12px;text-decoration:none;color:#2563eb}
    .muted{color:#666;font-size:14px}
  </style>
</head>
<body>
  <header>
    <div class="container" style="display:flex;align-items:center;justify-content:space-between;">
      <div>
        <strong>{{ config('app.name','SIPP PKL') }}</strong>
      </div>
      <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('pemberkasan.index') }}">Pemberkasan</a>
        <a href="{{ route('mitra.index') }}">Mitra</a>
        <a href="{{ route('profile.show') }}">Profile</a>
        <a href="{{ route('settings.index') }}">Pengaturan</a>
      </nav>
    </div>
  </header>

  <main class="container">
    @yield('content')
  </main>

  <footer>
    <div class="container">© {{ date('Y') }} SIPP PKL. Semua hak tersisa, sayangnya.</div>
  </footer>
</body>
</html>
