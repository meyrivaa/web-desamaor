<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>UMKM Desa &mdash; {{ $desa['nama'] }}</title>

    <meta name="description" content="Daftar produk UMKM dan usaha warga {{ $desa['nama'] }}.">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=8">

    <script defer src="{{ asset('js/navigation.js') }}?v=4"></script>
</head>

<body>

    <div class="chart-grain" aria-hidden="true"></div>

    <!-- NAVIGASI -->
    <header class="site-nav">
        <div class="nav-inner">

            <a class="brand" href="{{ route('listing') }}">
                <span class="brand-mark" aria-hidden="true">
                    <img src="{{ asset('uploads/logo-desa-maor.png') }}" alt="Logo Desa Maor" class="brand-logo">
                </span>

                <span class="brand-text">
                    <strong>{{ $desa['nama'] }}</strong>

                    <small>
                        {{ $desa['kecamatan'] }} &middot;
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
                <a href="{{ route('listing') }}">Beranda</a>
                <a href="{{ route('peta') }}">Peta Desa</a>
                <a href="{{ route('profil') }}">Visi &amp; Misi</a>
                <a href="{{ route('struktur') }}">Struktur Organisasi</a>
                <a href="{{ route('statistik') }}">Statistik Desa</a>
                <a href="{{ route('umkm') }}" aria-current="page">UMKM</a>
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


    <main class="umkm-page-main">

        <!-- JUDUL HALAMAN -->
        <header class="umkm-page-heading">

            <span class="umkm-page-eyebrow">
                Produk Warga
            </span>

            <h1>UMKM Desa Maor</h1>

            <p>
                Temukan produk unggulan dan usaha milik warga
                {{ $desa['nama'] }}. Hubungi penjual secara langsung
                melalui WhatsApp atau lihat lokasi usahanya.
            </p>

        </header>

        @if(count($daftar_umkm) > 0)

            <!-- PENCARIAN DAN FILTER -->
            <section class="umkm-filter-section" aria-label="Pencarian dan filter produk">

                <div class="umkm-filter-bar">

                    <div class="umkm-filter-field">
                        <label for="umkm-category">
                            Kategori
                        </label>

                        <select id="umkm-category">
                            <option value="semua">
                                Semua Kategori
                            </option>

                            <option value="makanan">
                                Makanan
                            </option>

                            <option value="minuman">
                                Minuman
                            </option>

                            <option value="kerajinan">
                                Kerajinan
                            </option>

                            <option value="pertanian">
                                Pertanian
                            </option>

                            <option value="jasa">
                                Jasa
                            </option>

                            <option value="lainnya">
                                Lainnya
                            </option>
                        </select>
                    </div>

                    <div class="umkm-search-field">
                        <label for="umkm-search">
                            Cari Produk
                        </label>

                        <input type="search" id="umkm-search" placeholder="Cari produk atau nama usaha..."
                            autocomplete="off">
                    </div>

                </div>

            </section>

        @endif


        <!-- DAFTAR PRODUK -->
        <section class="umkm-product-section" aria-label="Daftar produk UMKM">

            <div class="umkm-grid" id="umkm-grid">

                @forelse($daftar_umkm as $item)

                    <article class="umkm-card" data-category="{{ strtolower($item['kategori']) }}"
                        data-search="{{ strtolower($item['nama_produk']) }} {{ strtolower($item['nama_usaha']) }}">

                        <div class="umkm-card-image">

                            @if($item["gambar"])

                                <img src="{{ asset('uploads/' . $item['gambar']) }}" alt="{{ $item['nama_produk'] }}"
                                    loading="lazy" decoding="async">

                            @else

                                <div class="umkm-image-placeholder">

                                    <svg class="ui-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M6 8h12l1 13H5L6 8Z"></path>
                                        <path d="M9 8V6a3 3 0 0 1 6 0v2"></path>
                                    </svg>

                                    <p>Foto belum tersedia</p>

                                </div>

                            @endif

                            <span class="umkm-category-badge">
                                {{ $item["kategori"] }}
                            </span>

                        </div>


                        <div class="umkm-card-content">

                            <div class="umkm-business-name">
                                {{ $item["nama_usaha"] }}
                            </div>

                            <h2 class="umkm-product-name">
                                {{ $item["nama_produk"] }}
                            </h2>

                            @if($item["deskripsi"])

                                <p class="umkm-product-description">
                                    {{ $item["deskripsi"] }}
                                </p>

                            @endif

                            <div class="umkm-address">

                                <svg class="umkm-inline-icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="2.5"></circle>
                                </svg>

                                <p>
                                    {{ $item["alamat"] }}
                                </p>

                            </div>


                            <div class="umkm-card-actions">

                                <a class="umkm-whatsapp-button"
                                    href="https://wa.me/{{ $item['nomor_wa'] }}?text={{ urlencode(('Halo, saya tertarik dengan produk ' . $item['nama_produk'] . ' dari ' . $item['nama_usaha'])) }}"
                                    target="_blank" rel="noopener noreferrer">

                                    <svg class="umkm-inline-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8
                                                                                            8.5 8.5 0 0 1-7.6 4.7
                                                                                            8.38 8.38 0 0 1-3.8-.9
                                                                                            L3 21l1.9-5.7
                                                                                            a8.38 8.38 0 0 1-.9-3.8
                                                                                            8.5 8.5 0 0 1 4.7-7.6
                                                                                            8.38 8.38 0 0 1 3.8-.9
                                                                                            h.5a8.48 8.48 0 0 1 8 8Z">
                                        </path>
                                    </svg>

                                    <span>WhatsApp</span>
                                </a>
                                <a class="umkm-maps-button" href="{{ $item['maps_url'] }}" target="_blank"
                                    rel="noopener noreferrer">

                                    <svg class="umkm-inline-icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                                        <circle cx="12" cy="10" r="2.5"></circle>
                                    </svg>

                                    <span>Lokasi</span>
                                </a>

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="umkm-empty">
                        <h2>Belum Ada Produk UMKM</h2>
                    </div>

                @endforelse

            </div>


            <!-- PESAN JIKA FILTER TIDAK MENEMUKAN PRODUK -->
            <div class="umkm-filter-empty" id="umkm-filter-empty" hidden>
                <h2>Produk Tidak Ditemukan</h2>
            </div>

        </section>

    </main>

    @if(count($daftar_umkm) > 0)

        <script>
            const searchInput = document.getElementById("umkm-search");
            const categorySelect = document.getElementById("umkm-category");
            const cards = document.querySelectorAll(".umkm-card");
            const emptyResult = document.getElementById("umkm-filter-empty");

            function filterProducts() {
                const searchValue = searchInput.value
                    .toLowerCase()
                    .trim();

                const categoryValue = categorySelect.value
                    .toLowerCase();

                let visibleProducts = 0;

                cards.forEach((card) => {
                    const productText = card.dataset.search || "";
                    const productCategory = card.dataset.category || "";

                    const matchesSearch =
                        productText.includes(searchValue);

                    const matchesCategory =
                        categoryValue === "semua" ||
                        productCategory === categoryValue;

                    const shouldShow =
                        matchesSearch && matchesCategory;

                    card.hidden = !shouldShow;

                    if (shouldShow) {
                        visibleProducts += 1;
                    }
                });

                emptyResult.hidden =
                    visibleProducts !== 0 || cards.length === 0;
            }

            searchInput.addEventListener(
                "input",
                filterProducts
            );

            categorySelect.addEventListener(
                "change",
                filterProducts
            );
        </script>

    @endif

</body>

</html>