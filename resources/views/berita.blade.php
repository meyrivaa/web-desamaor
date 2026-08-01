<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Berita Desa &mdash; {{ $desa['nama'] }}</title>

  <meta name="description" content="Berita, kegiatan, dan pengumuman terbaru dari {{ $desa['nama'] }}.">

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=8">

  <script defer src="{{ asset('js/navigation.js') }}?v=4"></script>
  <script defer src="{{ asset('js/news-search.js') }}?v=1"></script>
</head>

<body>

  <div class="chart-grain" aria-hidden="true"></div>

  <!-- Navigasi -->
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
        <a href="{{ route('struktur') }}">Struktur Organisasi</a>
        <a href="{{ route('statistik') }}">Statistik Desa</a>
        <a href="{{ route('umkm') }}">UMKM</a>
        <a href="{{ route('berita') }}" aria-current="page">Berita</a>

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


  <main class="news-page-main">

    <header class="news-page-heading">
      <span class="news-page-eyebrow">
        Kabar Desa
      </span>

      <h1>Berita &amp; Pengumuman</h1>

      <p>
        Informasi terbaru mengenai kegiatan, pelayanan,
        pengumuman, dan program {{ $desa['nama'] }}.
      </p>
    </header>


    @if(count($berita) > 0)

      <section class="news-search-section" aria-label="Pencarian berita">

        <div class="news-search-bar">

          <div class="news-search-field">

            <label for="news-search">
              Cari Berita
            </label>

            <input type="search" id="news-search" placeholder="Cari judul atau isi ringkasan berita..." autocomplete="off"
              data-news-search>

          </div>

        </div>

      </section>

    @endif


    <section class="news-list-section" aria-label="Daftar berita desa">

      <div class="news-grid">

        @forelse($berita as $item)

          <article class="news-card" data-news-card data-search="{{ $item['judul'] }} {{ $item['ringkasan'] }}">

            <a href="{{ route('berita_detail', $item['id']) }}" class="news-image-link"
              aria-label="Baca berita {{ $item['judul'] }}">

              <div class="news-image">

                <img src="{{ asset('uploads/' . $item['gambar']) }}" alt="{{ $item['judul'] }}" loading="lazy"
                  decoding="async">

              </div>

            </a>

            <div class="news-content">

              <time class="news-date mono">
                {{ $item['tanggal'] }}
              </time>

              <h2 class="news-title">

                <a href="{{ route('berita_detail', $item['id']) }}">
                  {{ $item['judul'] }}
                </a>

              </h2>

              <p class="news-summary">
                {{ $item['ringkasan'] }}
              </p>

              <a href="{{ route('berita_detail', $item['id']) }}" class="news-readmore">

                Baca Selengkapnya
                <span aria-hidden="true">&rarr;</span>

              </a>

            </div>

          </article>

        @empty

          <div class="news-empty">
            <h2>Belum Ada Berita</h2>
          </div>

        @endforelse


        @if(count($berita) > 0)

          <div class="news-filter-empty" data-news-filter-empty hidden>

            <h2>Berita Tidak Ditemukan</h2>

            <p>
              Tidak ada berita yang sesuai dengan kata pencarian.
            </p>

          </div>

        @endif

      </div>

    </section>

  </main>

  @include('partials.footer')

</body>

</html>