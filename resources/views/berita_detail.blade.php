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

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=19">

  <script defer src="{{ asset('js/navigation.js') }}?v=4"></script>
</head>

<body>

  <div class="chart-grain" aria-hidden="true"></div>

  <!-- Navigasi -->
  <header class="site-nav">
    <div class="nav-inner">

      <a class="brand" href="{{ route('listing') }}">
        <span class="brand-mark" aria-hidden="true">
          <img src="{{ asset('uploads/logo-desa-maor.png') }}" alt="" class="brand-logo">
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

        <img src="{{ asset('uploads/' . $item['gambar']) }}" alt="{{ $item['judul'] }}" class="news-article-image">

      </figure>


      @php
        $isiBerita = $item['isi'] ?? '';

        $isiBerita = preg_replace(
          '/(?:\x{00A0}|&nbsp;|&#160;|&#xA0;)/iu',
          ' ',
          $isiBerita
        ) ?? $isiBerita;

        /*
         * Berita baru dari editor sudah berbentuk HTML.
         * Berita lama masih berbentuk teks biasa.
         */
        $isiMengandungHtml = preg_match(
          '/<[a-z][\s\S]*>/i',
          $isiBerita
        );
      @endphp

      <div class="news-article-body">
        @if ($isiMengandungHtml)

          {!! $isiBerita !!}

        @else

          @foreach (preg_split('/\r\n|\r|\n/', $isiBerita) as $paragraf)

            @if (trim($paragraf) !== '')
              <p>{{ $paragraf }}</p>
            @endif

          @endforeach

        @endif
      </div>

    </article>

  </main>

  @include('partials.footer')

</body>

</html>