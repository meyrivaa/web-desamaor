<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Struktur Organisasi &mdash; {{ $desa['nama'] }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=12">

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
        <a href="{{ route('profil') }}">Visi &amp; Misi</a>
        <a href="{{ route('struktur') }}" aria-current="page">Struktur Organisasi</a>
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

  <main class="profil-main struktur-main">

    <header class="profile-page-heading">
      <span class="profile-page-eyebrow">Pemerintahan Desa</span>

      <h1>Struktur Organisasi</h1>

      <p>
        Jajaran perangkat Pemerintah {{ $desa['nama'] }} yang menjalankan
        pelayanan dan administrasi pemerintahan desa.
      </p>
    </header>

    <section class="vm-section structure-section">

      <div class="org-grid">

        @forelse($daftar_struktur as $orang)

          <article class="org-card {{ $orang['jabatan'] === 'Kepala Desa' ? 'org-kades' : '' }}">

            <div class="org-photo-wrapper">
              @if($orang["foto"] && $orang["foto"] != "default.jpg")

                <img src="{{ asset('uploads/' . $orang['foto']) }}" alt="Foto {{ $orang['nama'] }}" class="org-photo">

              @else

                <div class="org-photo-placeholder">

                  <svg class="org-placeholder-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M4 21a8 8 0 0 1 16 0"></path>
                  </svg>

                </div>

              @endif
            </div>

            <div class="org-card-content">
              <div class="org-role">
                {{ $orang["jabatan"] }}
              </div>

              <div class="org-name">
                {{ $orang["nama"] }}
              </div>
            </div>

          </article>

        @empty

          <div class="org-empty">
            <p>Data struktur organisasi belum tersedia.</p>
          </div>

        @endforelse

      </div>

    </section>

  </main>

  @include('partials.footer')

</body>

</html>