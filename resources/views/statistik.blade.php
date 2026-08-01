<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.favicon')

    <title>Statistik Desa &mdash; {{ $desa['nama'] }}</title>

    <meta name="description" content="Data statistik kependudukan dan kondisi demografis {{ $desa['nama'] }}.">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=26">

    <script defer src="{{ asset('js/navigation.js') }}?v=4"></script>
    <script defer src="{{ asset('js/statistics-counter.js') }}?v=1"></script>
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

                    $totalPenduduk = (int) $statistik['total_penduduk'];
                    $jumlahLakiLaki = (int) $statistik['laki_laki'];
                    $jumlahPerempuan = (int) $statistik['perempuan'];

                    $persentaseLakiLaki = $totalPenduduk > 0
                        ? ($jumlahLakiLaki / $totalPenduduk) * 100
                        : 0;

                    $persentasePerempuan = $totalPenduduk > 0
                        ? ($jumlahPerempuan / $totalPenduduk) * 100
                        : 0;

                    $ringkasanStatistik = [
                        [
                            'label' => 'Laki-laki',
                            'value' => $jumlahLakiLaki,
                            'unit' => 'Jiwa',
                            'icon' => 'person',
                        ],
                        [
                            'label' => 'Perempuan',
                            'value' => $jumlahPerempuan,
                            'unit' => 'Jiwa',
                            'icon' => 'person',
                        ],
                        [
                            'label' => 'Kepala Keluarga',
                            'value' => (int) $statistik['jumlah_kk'],
                            'unit' => 'KK',
                            'icon' => 'family',
                        ],
                        [
                            'label' => 'Rumah Tangga',
                            'value' => (int) $statistik['jumlah_rumah_tangga'],
                            'unit' => 'Rumah',
                            'icon' => 'home',
                        ],
                    ];
                @endphp


                <section class="statistics-feature-card" aria-label="Ringkasan utama statistik Desa Maor">

                    <div class="statistics-feature-info">

                        <span class="statistics-feature-label">
                            Ringkasan Utama
                        </span>

                        <h2>
                            Jumlah Penduduk {{ $desa['nama'] }}
                        </h2>

                        <p>
                            Data kependudukan terakhir diperbarui pada
                            {{ $tanggalData }}.
                        </p>


                        <div class="statistics-ratio">

                            <div class="statistics-ratio-header">

                                <span>
                                    Laki-laki ·
                                    <strong>
                                        {{ number_format(
                $jumlahLakiLaki,
                0,
                ',',
                '.'
            ) }}
                                    </strong>
                                </span>

                                <span>
                                    Perempuan ·
                                    <strong>
                                        {{ number_format(
                $jumlahPerempuan,
                0,
                ',',
                '.'
            ) }}
                                    </strong>
                                </span>

                            </div>


                            <div class="statistics-ratio-bar" aria-label="Perbandingan jumlah laki-laki dan perempuan">

                                <span class="statistics-ratio-fill statistics-ratio-fill--male" data-statistics-ratio
                                    data-width="{{ number_format(
                $persentaseLakiLaki,
                4,
                '.',
                ''
            ) }}">
                                </span>

                                <span class="statistics-ratio-fill statistics-ratio-fill--female" data-statistics-ratio
                                    data-width="{{ number_format(
                $persentasePerempuan,
                4,
                '.',
                ''
            ) }}">
                                </span>

                            </div>

                        </div>

                    </div>


                    <div class="statistics-feature-total">

                        <strong data-statistics-counter data-count="{{ $totalPenduduk }}">

                            {{ number_format(
                $totalPenduduk,
                0,
                ',',
                '.'
            ) }}
                        </strong>

                        <span>Jiwa</span>

                    </div>

                </section>


                <section class="statistics-metric-grid" aria-label="Ringkasan statistik kependudukan">

                    @foreach ($ringkasanStatistik as $ringkasan)

                            <article class="statistics-metric-card">

                                <div class="statistics-metric-icon" aria-hidden="true">

                                    @if ($ringkasan['icon'] === 'home')

                                        <svg viewBox="0 0 24 24">
                                            <path d="M3 11 12 4l9 7"></path>
                                            <path d="M5 10v10h14V10"></path>
                                        </svg>

                                    @elseif ($ringkasan['icon'] === 'family')

                                        <svg viewBox="0 0 24 24">
                                            <path d="M4 21V9l8-5 8 5v12"></path>
                                            <path d="M9 21v-6h6v6"></path>
                                        </svg>

                                    @else

                                        <svg viewBox="0 0 24 24">
                                            <circle cx="12" cy="7" r="4"></circle>
                                            <path d="M5 21c0-4.5 3-8 7-8s7 3.5 7 8"></path>
                                        </svg>

                                    @endif

                                </div>

                                <span class="statistics-metric-label">
                                    {{ $ringkasan['label'] }}
                                </span>

                                <strong class="statistics-metric-value" data-statistics-counter data-count="{{ $ringkasan['value'] }}">

                                    {{ number_format(
                            $ringkasan['value'],
                            0,
                            ',',
                            '.'
                        ) }}
                                </strong>

                                <small class="statistics-metric-unit">
                                    {{ $ringkasan['unit'] }}
                                </small>

                            </article>

                    @endforeach

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

    @include('partials.footer')

</body>

</html>