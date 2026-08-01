<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  @include('partials.favicon')
  <title>Beranda &mdash; {{ $desa['nama'] }}</title>
  <meta name="description"
    content="Peta geospasial dan titik lokasi (point of interest) {{ $desa['nama'] }}, {{ $desa['kecamatan'] }}, {{ $desa['kabupaten'] }}." />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=22" />

  <script defer src="{{ asset('js/navigation.js') }}?v=2"></script>
</head>

<body>

  <div class="chart-grain" aria-hidden="true"></div>

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
        <a href="{{ route('listing') }}" aria-current="page">Beranda</a>
        <a href="{{ route('peta') }}">Peta Desa</a>
        <a href="{{ route('profil') }}">Visi &amp; Misi</a>
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

  <main>
    <section class="home-hero" aria-labelledby="home-hero-title">

      <div class="home-hero-media" aria-hidden="true">

        <video class="home-hero-video" autoplay muted loop playsinline preload="metadata">

          <source src="{{ asset('video/profil-desa.mp4') }}" type="video/mp4">

        </video>

      </div>

      <div class="home-hero-overlay" aria-hidden="true"></div>

      <div class="home-hero-content">

        <span class="home-hero-eyebrow">
          Portal Resmi Desa Maor
        </span>

        <h1 id="home-hero-title">
          Selamat Datang di Desa Maor
        </h1>

        <p class="home-hero-description">
          Portal informasi Desa Maor yang menghadirkan profil desa, kabar terbaru, ragam produk UMKM lokal, dan potensi
          pada sektor agrikultur tebu dan palawija dalam satu tempat.
        </p>

        <div class="home-hero-actions">

          <a href="#profil-desa" class="home-hero-button home-hero-button--primary">

            Jelajahi Desa
          </a>

          <a href="{{ route('peta') }}" class="home-hero-button home-hero-button--secondary">

            Lihat Peta Desa
          </a>

        </div>

        <dl class="home-hero-meta">

          <div>
            <dt>Provinsi</dt>

            <dd>
              {{ str_replace('Provinsi ', '', $desa['provinsi']) }}
            </dd>
          </div>

          <div>
            <dt>Kabupaten</dt>

            <dd>
              {{ str_replace('Kabupaten ', '', $desa['kabupaten']) }}
            </dd>
          </div>

          <div>
            <dt>Kode Wilayah</dt>

            <dd class="mono">
              {{ $desa['kode_wilayah'] }}
            </dd>
          </div>

        </dl>

      </div>

    </section>

    <section class="village-profile-section" id="profil-desa">

      <!-- =====================================================
       SAMBUTAN KEPALA DESA
       ===================================================== -->
      <article class="welcome-panel">

        <!-- Bagian foto kepala desa -->
        <div class="welcome-portrait">

          <div class="welcome-photo-frame">

            @if($kepala_desa && $kepala_desa["foto"] && $kepala_desa["foto"] != "default.jpg")

              <img src="{{ asset('uploads/' . $kepala_desa['foto']) }}" alt="Foto {{ $kepala_desa['nama'] }}"
                class="welcome-photo">

            @else

              <div class="welcome-photo-placeholder">

                <svg class="ui-icon" viewBox="0 0 24 24" aria-hidden="true">
                  <circle cx="12" cy="8" r="4"></circle>
                  <path d="M4 21a8 8 0 0 1 16 0"></path>
                </svg>

              </div>

            @endif

          </div>

          <div class="welcome-identity">
            <span class="welcome-position">
              @if($kepala_desa)
                {{ $kepala_desa["jabatan"] }}
              @else
                Kepala Desa
              @endif
            </span>

            <h3>
              @if($kepala_desa)
                {{ $kepala_desa["nama"] }}
              @else
                Nama Kepala Desa
              @endif
            </h3>

            <p>Pemerintah {{ $desa['nama'] }}</p>
          </div>

        </div>

        <!-- Bagian isi sambutan -->
        <div class="welcome-content">

          <h2>Sambutan Kepala Desa</h2>

          <div class="profile-title-line">
            <span></span>
          </div>

          <div class="welcome-copy" tabindex="0" aria-label="Isi sambutan Kepala Desa">

            <p>
              "Assalamu'alaikum Warahmatullahi Wabarakatuh.<br>
              Salam sejahtera untuk kita semua.
            </p>

            <p>
              Puji syukur ke hadirat Allah SWT atas limpahan rahmat dan
              karunia-Nya, sehingga Website Resmi Desa Maor, Kecamatan
              Kebangbahu, Kabupaten Lamongan dapat hadir sebagai media
              informasi bagi seluruh masyarakat.
            </p>

            <p>
              Website ini merupakan wujud komitmen Pemerintah Desa Maor
              dalam mendukung keterbukaan informasi publik. Melalui website
              ini, kami menyajikan berbagai informasi mengenai profil desa,
              struktur pemerintahan, infografis desa, berita dan kegiatan,
              serta berbagai potensi yang dimiliki Desa Maor agar dapat
              diakses dengan mudah oleh masyarakat maupun masyarakat luas.
            </p>

            <p>
              Kami berharap website ini dapat menjadi sarana komunikasi dan
              informasi yang mempererat hubungan antara pemerintah desa
              dengan masyarakat, sekaligus menjadi media untuk memperkenalkan
              potensi dan perkembangan Desa Maor kepada khalayak yang lebih luas.
            </p>

            <p>
              Kami mengajak seluruh masyarakat untuk terus menjaga semangat
              kebersamaan, gotong royong, dan partisipasi dalam mendukung
              pembangunan desa demi terwujudnya Desa Maor yang maju,
              mandiri, dan sejahtera.
            </p>

            <p>
              Terima kasih kepada seluruh pihak yang telah mendukung
              terwujudnya website ini. Semoga website Desa Maor dapat
              memberikan manfaat sebagai sumber informasi yang akurat,
              transparan, dan terpercaya.
            </p>

            <p>
              Wassalamu'alaikum Warahmatullahi Wabarakatuh.
              {{ $desa['sambutan_kades'] }}"
            </p>

          </div>

        </div>

      </article>


      <!-- =====================================================
       SEJARAH DESA
       ===================================================== -->
      <article class="history-panel">

        <!-- Bagian judul sejarah -->
        <div class="history-heading">

          <h2>Sejarah Singkat</h2>

          <div class="history-decoration">
            <span></span>
            <span></span>
            <span></span>
          </div>

        </div>

        <!-- Bagian isi sejarah -->
        <div class="history-copy">

          <p>
            Sejarah Lahirnya Desa Maor ini tidak bisa dilepaskan dari
            jasa-jasa para tokoh Kharismatik dalam mengembangkan peradaban
            islam yang ada di pulau jawa, khususnya pengembangan islam yang
            ada di lamongan.
          </p>

          <p>
            Pada masa itu Masyarakat Desa Maor bermukim di sebelah selatan
            dusun kalibogo desa kaliwates dengan nama Desa Klampok, karena
            letaknya yang berdekatan itulah sesepuh desa khawatir untuk
            kebutuhan hidup warganya. Kemudian sesepuh desa yang bernama
            <strong>SARPIN/Mbah TIBAN</strong> tersebut pergi keselatan
            menyeberangi sungai menuju hutan dan membuka hutan tersebut
            untuk di jadikan Desa dan tempat tinggal bagi warganya. Pada
            saat membuka hutan (babat alas) tersebut terdengar suara
            <strong>“NGAOR-NGAOR”</strong> yang tak lain adalah seekor
            <strong>KUCING</strong>, akhirnya sesepuh desa tersebut tempat
            itu diberi nama desa <strong>“MAOR”</strong>.
          </p>

          <p>
            Kucingnya menghadap kedepan lurus dan dilingkari garis segilima
            yang artinya beriman Kepada Tuhan Yang Maha Esa dan Berpedoma
            Pada Pengamalan Pancasila.
          </p>

          <p>
            Dari Gambar Padi dan Kapas mengambarkan murah sandang pangan
            masyarakat serba kecukupan/makmur dan bertaqwa kepada Tuhan
            Yang Maha Esa.
          </p>

          <p>
            Bintang yang artinya menerangi dan memberi cahaya bagi bangsa
            dan negara. Terus memberi cahaya seperti tuhan yang maknanya
            adalah jalan terang agar negara dapat menempuh jalan yang benar.
          </p>

          <p>
            {{ $desa['sejarah'] }}
          </p>

        </div>

      </article>

    </section>

    <section class="agenda-section">

      <!-- Judul bagian agenda -->
      <header class="agenda-section-header">

        <div class="agenda-heading-group">

          <svg class="ui-icon agenda-heading-icon" viewBox="0 0 24 24" aria-hidden="true">

            <rect x="3" y="5" width="18" height="16" rx="2"></rect>
            <path d="M16 3v4"></path>
            <path d="M8 3v4"></path>
            <path d="M3 10h18"></path>
            <path d="M8 14h2"></path>
            <path d="M14 14h2"></path>
            <path d="M8 17h2"></path>
            <path d="M14 17h2"></path>

          </svg>

          <div class="agenda-heading-content">

            <span class="agenda-eyebrow">
              Agenda Desa
            </span>

            <h2>
              Agenda &amp; Kalender Kegiatan Desa
            </h2>

            <p class="agenda-description">
              Informasi jadwal kegiatan yang akan dilaksanakan di Desa Maor.
            </p>

          </div>

        </div>

      </header>


      <!-- Daftar agenda -->
      <div class="agenda-list-card">

        <ul class="agenda-list">

          @forelse($agenda as $item)

            <li class="agenda-item">

              <!-- Tanggal kegiatan -->
              <div class="agenda-date">

                <span class="agenda-date-day">
                  {{ $item['tgl_angka'] }}
                </span>

                <span class="agenda-date-month">
                  {{ $item['bln_teks'] }}
                </span>

              </div>


              <!-- Informasi kegiatan -->
              <div class="agenda-item-content">

                <h3>{{ $item['judul'] }}</h3>

                <div class="agenda-meta">

                  <span class="agenda-meta-item">

                    <svg class="ui-icon ui-icon--small" viewBox="0 0 24 24" aria-hidden="true">

                      <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
                      <circle cx="12" cy="10" r="2.5"></circle>

                    </svg>

                    <span>{{ $item['lokasi'] }}</span>

                  </span>


                  <span class="agenda-meta-separator" aria-hidden="true">
                    •
                  </span>


                  <span class="agenda-meta-item">

                    <svg class="ui-icon ui-icon--small" viewBox="0 0 24 24" aria-hidden="true">

                      <circle cx="12" cy="12" r="9"></circle>
                      <path d="M12 7v5l3 2"></path>

                    </svg>

                    <span>{{ $item['waktu'] }}</span>

                  </span>

                </div>

              </div>

            </li>

          @empty

            <li class="agenda-empty">
              <p>Belum ada agenda kegiatan desa terdekat.</p>
            </li>

          @endforelse

        </ul>

      </div>

    </section>

    @include('partials.footer')

  </main>

</body>

</html>