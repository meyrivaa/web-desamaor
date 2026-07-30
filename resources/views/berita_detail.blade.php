<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $item['judul'] }} &mdash; {{ $desa['nama'] }}</title>

  <meta name="description" content="{{ $item['ringkasan'] }}">

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=6">

  <script defer src="{{ asset('js/navigation.js') }}?v=4"></script>
</head>

<body>

  <div class="chart-grain" aria-hidden="true"></div>

  <!-- Navigasi -->
  <header class="site-nav">
    <div class="nav-inner">

      <a class="brand" href="{{ route('listing') }}">
        <span class="brand-mark" aria-hidden="true">🌾</span>

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
        <a href="{{ route('infografis') }}">Infografis</a>
        <a href="{{ route('umkm') }}">UMKM</a>
        <a href="{{ route('berita') }}" aria-current="page">Berita</a>
      </nav>

    </div>
  </header>


  <main class="news-detail-main">

    <a href="{{ route('berita') }}" class="news-back-link">
      <span aria-hidden="true">&larr;</span>
      Kembali ke Daftar Berita
    </a>


    <article class="news-article">

      <header class="news-article-header">

        <span class="news-article-label">
          Berita Desa
        </span>

        <h1>{{ $item['judul'] }}</h1>

        <time class="news-article-date mono">
          Dipublikasikan pada: {{ $item['tanggal'] }}
        </time>

      </header>


      <figure class="news-article-figure">

        <img src="{{ asset('uploads/' . $item['gambar']) }}" alt="{{ $item['judul'] }}"
          class="news-article-image">

      </figure>


      <div class="news-article-body">
        {{ $item['isi'] }}
      </div>

    </article>

  </main>

</body>

</html>