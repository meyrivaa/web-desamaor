<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Profil &mdash; {{ $desa['nama'] }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=13">

  <script defer src="{{ asset('js/navigation.js') }}?v=3"></script>
</head>

<body>

  <div class="chart-grain" aria-hidden="true"></div>

  <header class="site-nav">
    <div class="nav-inner">

      <a class="brand" href="{{ route('listing') }}">
        <span class="brand-mark" aria-hidden="true">
          <img src="{{ asset('uploads/logo-desa-maor.png') }}" alt="Logo Desa Maor" class="brand-logo">
        </span>

        <span class="brand-text">
          <strong>{{ $desa['nama'] }}</strong>
          <small>
            {{ $desa['kecamatan'] }} &middot; {{ $desa['kabupaten'] }}
          </small>
        </span>
      </a>

      <button class="nav-toggle" type="button" aria-label="Buka menu navigasi" aria-expanded="false"
        aria-controls="primary-navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>

      <nav class="nav-links" id="primary-navigation" aria-label="Navigasi utama">
        <a href="{{ route('listing') }}">Beranda</a>
        <a href="{{ route('peta') }}">Peta Desa</a>
        <a href="{{ route('profil') }}" aria-current="page">Visi &amp; Misi</a>
        <a href="{{ route('struktur') }}">Struktur Organisasi</a>
        <a href="{{ route('statistik') }}">Statistik Desa</a>
        <a href="{{ route('umkm') }}">UMKM</a>
        <a href="{{ route('berita') }}">Berita</a>

        <a href="{{ route('admin_login') }}" class="nav-admin-link nav-admin-icon-only"
          aria-label="Masuk ke halaman admin" title="Masuk ke halaman admin">
          <svg class="nav-admin-icon" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="12" cy="8" r="4"></circle>
            <path d="M4 21a8 8 0 0 1 16 0"></path>
          </svg>
        </a>
      </nav>

    </div>
  </header>

  <main class="profil-main">

    <header class="profile-page-heading">
      <h1>Visi &amp; Misi</h1>
      <p>
        Arah pembangunan dan komitmen Pemerintah {{ $desa['nama'] }}
        dalam memberikan pelayanan kepada masyarakat.
      </p>
    </header>

    <section class="vm-section">
      <div class="card vm-card vm-card--vision">

        <div class="vm-card-header">
          <h2 class="vm-title">Visi</h2>
        </div>

        <p class="vm-text visi-text">
          {{ $desa['visi'] }}
        </p>

      </div>
    </section>

    <section class="vm-section">
      <div class="card vm-card vm-card--mission">

        <div class="vm-card-header">
          <h2 class="vm-title">Misi</h2>
        </div>

        <ol class="vm-list">
          @foreach($desa['misi'] as $item)
            <li>{{ $item }}</li>
          @endforeach
        </ol>

      </div>
    </section>

  </main>

  @include('partials.footer')

</body>

</html>