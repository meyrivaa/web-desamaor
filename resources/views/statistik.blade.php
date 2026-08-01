<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Statistik Desa &mdash; {{ $desa['nama'] }}</title>

    <meta name="description" content="Data statistik kependudukan dan kondisi demografis {{ $desa['nama'] }}.">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=21">

    <script defer src="{{ asset('js/navigation.js') }}?v=4"></script>
</head>

<body>

    <!-- Navigasi utama -->
    <header class="site-nav">
        <div class="nav-inner">

            <a class="brand" href="{{ route('listing') }}">
                <span class="brand-mark" aria-hidden="true">
                    <img src="{{ asset('uploads/logo-desa-maor.png') }}" alt="" class="brand-logo">
                </span>

                <span class="brand-text">
                    <strong>{{ $desa['nama'] }}</strong>

                    <small>
                        {{ $desa['kecamatan'] }}
                        &middot;
                        {{ $desa['kabupaten'] }}
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

                <a href="{{ route('listing') }}">
                    Beranda
                </a>

                <a href="{{ route('peta') }}">
                    Peta Desa
                </a>

                <a href="{{ route('profil') }}">
                    Visi &amp; Misi
                </a>

                <a href="{{ route('struktur') }}">
                    Struktur Organisasi
                </a>

                <a href="{{ route('statistik') }}" aria-current="page">
                    Statistik Desa
                </a>

                <a href="{{ route('umkm') }}">
                    UMKM
                </a>

                <a href="{{ route('berita') }}">
                    Berita
                </a>

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


    <main class="statistics-main">

        <header class="statistics-heading">

            <span class="statistics-eyebrow">
                Data Kependudukan
            </span>

            <h1>Statistik Desa Maor</h1>

            <p>
                Ringkasan data kependudukan Desa Maor berdasarkan jumlah penduduk, jenis kelamin, kepala keluarga, dan
                rumah tangga.
            </p>

        </header>


        @if ($statistik)

                @php
                    $tanggalData = \Carbon\Carbon::parse(
                        $statistik['tanggal_data']
                    )->translatedFormat('d F Y');
                  @endphp

                <!-- Total penduduk -->
                <section class="statistics-total-card">

                    <span class="statistics-total-label">
                        Total Penduduk
                    </span>

                    <strong class="statistics-total-number">
                        {{ number_format(
                $statistik['total_penduduk'],
                0,
                ',',
                '.'
            ) }}
                    </strong>

                    <p>
                        jiwa berdasarkan data per {{ $tanggalData }}
                    </p>

                </section>


                <!-- Ringkasan utama -->
                <section class="statistics-summary-grid" aria-label="Ringkasan statistik kependudukan">

                    <article class="statistics-summary-card">

                        <span>Laki-laki</span>

                        <strong>
                            {{ number_format(
                $statistik['laki_laki'],
                0,
                ',',
                '.'
            ) }}
                        </strong>

                        <small>Jiwa</small>

                    </article>


                    <article class="statistics-summary-card">

                        <span>Perempuan</span>

                        <strong>
                            {{ number_format(
                $statistik['perempuan'],
                0,
                ',',
                '.'
            ) }}
                        </strong>

                        <small>Jiwa</small>

                    </article>


                    <article class="statistics-summary-card">

                        <span>Kepala Keluarga</span>

                        <strong>
                            {{ number_format(
                $statistik['jumlah_kk'],
                0,
                ',',
                '.'
            ) }}
                        </strong>

                        <small>KK</small>

                    </article>


                    <article class="statistics-summary-card">

                        <span>Rumah Tangga</span>

                        <strong>
                            {{ number_format(
                $statistik['jumlah_rumah_tangga'],
                0,
                ',',
                '.'
            ) }}
                        </strong>

                        <small>Rumah</small>

                    </article>

                </section>

        @else

            <section class="statistics-empty">

                <h2>Data Statistik Belum Tersedia</h2>

                <p>
                    Data statistik Desa Maor belum ditambahkan
                    melalui halaman admin.
                </p>

            </section>

        @endif

    </main>

</body>

</html>