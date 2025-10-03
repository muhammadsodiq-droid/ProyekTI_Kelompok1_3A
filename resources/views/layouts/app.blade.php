<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? config('app.name', 'SIPP PKL') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      margin: 0;
      color: #111;
      background: #f9fafb;
    }
    header {
      background: #fff;
      border-bottom: 1px solid #e5e7eb;
    }
    header .container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 16px;
      flex-wrap: wrap;
    }
    .brand {
      display: flex;
      align-items: center;
      gap: 8px;
      font-weight: 600;
      font-size: 18px;
    }
    nav {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
    }
    nav a {
      text-decoration: none;
      color: #374151;
      font-weight: 500;
      padding: 6px 10px;
      border-radius: 6px;
    }
    nav a.active {
      background: #d1fae5;
      color: #059669;
      font-weight: 600;
    }
    /* 🔹 container full 100% */
    .container {
      width: 100%;
      margin: 0 auto;
      padding: 20px 16px;
      box-sizing: border-box; /* biar padding nggak bikin geser */
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 16px;
      margin-top: 20px;
    }
    .card {
      display: block;
      background: #fff;
      border: 1px solid #e5e7eb;
      border-radius: 16px;
      padding: 16px;
      text-decoration: none;
      color: inherit;
      transition: all .2s;
    }
    .card:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transform: translateY(-2px);
    }
    .card strong {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 8px;
      font-size: 16px;
    }
    .count-pill {
      background: #f3f4f6;
      border-radius: 999px;
      padding: 4px 10px;
      font-size: 12px;
    }
    .progress {
      height: 8px;
      background: #e5e7eb;
      border-radius: 9999px;
      overflow: hidden;
      margin-top: 6px;
    }
    .progress > span {
      display: block;
      height: 100%;
      background: #34d399;
    }
    footer {
      border-top: 1px solid #e5e7eb;
      color: #6b7280;
      font-size: 13px;
      text-align: center;
      padding: 16px;
      margin-top: 40px;
    }

    /* 🔹 Tambahan responsif */
    @media (max-width: 768px) {
      header .container {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
      }
      nav {
        width: 100%;
        gap: 4px;
      }
      nav a {
        display: inline-block;
      }
    }

    @media (max-width: 480px) {
      .grid {
        grid-template-columns: 1fr;
      }
      .card strong {
        font-size: 14px;
      }
      footer {
        font-size: 12px;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="container">
      <div class="brand">👥 {{ config('app.name','SIPP PKL') }}</div>
      <nav>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('mitra.index') }}" class="{{ request()->routeIs('mitra.*') ? 'active' : '' }}">Mitra/Instansi</a>
        <a href="{{ route('pemberkasan.index') }}" class="{{ request()->routeIs('pemberkasan.*') ? 'active' : '' }}">Pemberkasan</a>
        <a href="{{ route('profile.show') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
        <a href="{{ route('settings.index') }}" class="{{ request()->routeIs('settings.*') ? 'active' : '' }}">Pengaturan</a>
      </nav>
    </div>
  </header>

  <main class="container">
    @yield('content')
  </main>

  <footer>
    SIPP-PKL · Laravel · {{ date('Y') }} · Sistem Informasi Pengelolaan PKL Berbasis PBL Web Kelompok 1 3A.
  </footer>
</body>
</html>
