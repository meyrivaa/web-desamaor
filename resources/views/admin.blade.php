<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @include('partials.favicon')

  <title>Dashboard Admin &mdash; {{ $desa['nama'] }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=16" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v=15" />
  <style>
    /* --- STYLING KHUSUS ADMIN DASHBOARD --- */
    .admin-header-title {
      text-align: center;
      margin-bottom: 0.5rem;
      color: var(--light-text);
      font-family: var(--font-serif);
      font-size: 2.5rem;
    }

    /* Pembungkus khusus halaman admin */
    .admin-main {
      width: 100%;
      max-width: 1200px;

      margin: 0 auto;
      padding: 2rem 2rem 4rem;

      gap: 1.5rem;
    }

    /* Layout dua card per baris pada desktop dan tablet */
    .admin-grid {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));

      gap: 1.25rem;
      align-items: stretch;

      width: 100%;
      margin-bottom: 0;
    }

    /* Setiap card menjadi item langsung di dalam grid */
    .admin-grid>.admin-card {
      min-width: 0;
      align-self: stretch;
    }

    /* Semua card daftar menggunakan lebar penuh */
    .admin-grid>.admin-list-card {
      grid-column: 1 / -1;

      width: 100%;
      min-width: 0;
      max-width: none;

      margin: 0;
      padding: 2.5rem;
    }

    /* Desain Kartu Formulir */
    .admin-card {
      background: #ffffff;
      border: 1px solid var(--light-border);
      border-radius: 12px;
      padding: 2.5rem;
      box-shadow: 0 10px 30px var(--light-shadow);
    }

    .admin-card h2 {
      font-family: var(--font-serif);
      font-size: 1.6rem;
      color: var(--rust-buoy);
      margin-bottom: 1.5rem;
      border-bottom: 1px solid var(--light-border);
      padding-bottom: 1rem;
    }

    /* Desain Input & Label */
    .admin-form {
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }

    .form-group label {
      font-size: 0.85rem;
      color: var(--muted-sage);
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: block;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .form-control {
      width: 100%;
      padding: 0.85rem;
      border-radius: 6px;
      border: 1px solid var(--light-border);
      background: #ffffff;
      color: var(--light-text);
      font-family: var(--font-sans);
      transition: all 0.3s ease;
    }

    .form-control:focus {
      outline: none;
      border-color: var(--rust-buoy-lt);
      background: #ffffff;
      box-shadow: 0 0 0 3px rgba(192, 87, 42, 0.15);
    }

    .form-control::placeholder {
      color: #96a29e;
    }

    .form-control option {
      background: #ffffff;
      color: var(--light-text);
    }

    .grid-2-col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1rem;
    }

    /* Desain Tombol */
    .btn-submit {
      width: 100%;
      padding: 1rem;
      font-weight: 600;
      font-size: 1rem;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 1rem;
      font-family: var(--font-sans);
    }

    .btn-news {
      background: var(--rust-buoy-lt);
      color: white;
    }

    .btn-news:hover {
      background: #a54b20;
      transform: translateY(-2px);
    }

    .btn-poi {
      background: var(--tide-teal);
      color: white;
    }

    .btn-poi:hover {
      background: #24584e;
      transform: translateY(-2px);
    }

    /* Tampilan admin untuk tablet */
    @media (max-width: 900px) {
      .admin-main {
        padding: 1.5rem 1rem 3rem;
        gap: 1.25rem;
      }

      /* Tablet tetap menggunakan dua card per baris */
      .admin-grid {
        gap: 1.25rem;
      }

      .admin-card {
        width: 100%;
        min-width: 0;
        padding: 1.5rem;
      }

      .admin-grid>.admin-list-card {
        padding: 1.5rem;
      }
    }

    /* Tampilan satu kolom khusus HP */
    @media (max-width: 600px) {
      .admin-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
      }

      .grid-2-col {
        grid-template-columns: 1fr;
        gap: 1.25rem;
      }
    }

    /* Editor isi berita */
    .admin-rich-text-editor {
      width: 100%;
    }

    .admin-rich-text-editor .ql-toolbar.ql-snow {
      border: 1px solid var(--light-border);
      border-radius: 6px 6px 0 0;
      background: #f8faf9;
    }

    .admin-rich-text-editor .ql-container.ql-snow {
      border: 1px solid var(--light-border);
      border-top: none;
      border-radius: 0 0 6px 6px;
      background: #ffffff;
      font-family: var(--font-sans);
    }

    .admin-rich-text-editor .ql-editor {
      min-height: 260px;
      padding: 1rem;
      color: var(--light-text);
      font-size: 1rem;
      line-height: 1.75;
    }

    .admin-rich-text-editor .ql-editor.ql-blank::before {
      color: #96a29e;
      font-style: normal;
    }
  </style>
</head>

<body>

  <!-- Kumpulan ikon SVG admin -->
  <svg class="svg-sprite" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">

    <symbol id="icon-admin" viewBox="0 0 24 24">
      <rect x="4" y="3" width="16" height="18" rx="2"></rect>
      <path d="M8 7h8"></path>
      <path d="M8 11h8"></path>
      <path d="M8 15h3"></path>
    </symbol>

    <symbol id="icon-news" viewBox="0 0 24 24">
      <rect x="3" y="5" width="18" height="14" rx="2"></rect>
      <path d="M7 9h4"></path>
      <path d="M7 13h4"></path>
      <path d="M14 9h3"></path>
      <path d="M14 13h3"></path>
      <path d="M7 16h10"></path>
    </symbol>

    <symbol id="icon-chart" viewBox="0 0 24 24">
      <path d="M4 19V9"></path>
      <path d="M10 19V5"></path>
      <path d="M16 19v-7"></path>
      <path d="M22 19V3"></path>
      <path d="M2 19h20"></path>
    </symbol>

    <symbol id="icon-location" viewBox="0 0 24 24">
      <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"></path>
      <circle cx="12" cy="10" r="2.5"></circle>
    </symbol>

    <symbol id="icon-calendar" viewBox="0 0 24 24">
      <rect x="3" y="5" width="18" height="16" rx="2"></rect>
      <path d="M8 3v4"></path>
      <path d="M16 3v4"></path>
      <path d="M3 10h18"></path>
    </symbol>

    <symbol id="icon-user" viewBox="0 0 24 24">
      <circle cx="12" cy="8" r="4"></circle>
      <path d="M4 21a8 8 0 0 1 16 0"></path>
    </symbol>

    <symbol id="icon-users" viewBox="0 0 24 24">
      <circle cx="9" cy="8" r="3"></circle>
      <circle cx="17" cy="9" r="2.5"></circle>
      <path d="M3 20a6 6 0 0 1 12 0"></path>
      <path d="M14 15a5 5 0 0 1 7 5"></path>
    </symbol>

    <symbol id="icon-store" viewBox="0 0 24 24">
      <path d="M4 10h16"></path>
      <path d="M5 10v10h14V10"></path>
      <path d="M3 10 5 4h14l2 6"></path>
      <path d="M9 20v-6h6v6"></path>
    </symbol>

    <symbol id="icon-list" viewBox="0 0 24 24">
      <path d="M9 6h11"></path>
      <path d="M9 12h11"></path>
      <path d="M9 18h11"></path>
      <circle cx="4" cy="6" r="1"></circle>
      <circle cx="4" cy="12" r="1"></circle>
      <circle cx="4" cy="18" r="1"></circle>
    </symbol>

    <symbol id="icon-image" viewBox="0 0 24 24">
      <rect x="3" y="4" width="18" height="16" rx="2"></rect>
      <circle cx="9" cy="9" r="2"></circle>
      <path d="m4 17 5-5 4 4 2-2 5 5"></path>
    </symbol>

  </svg>

  <div class="chart-grain" aria-hidden="true"></div>

  <!-- Navigasi Minimalis Admin -->
  <header class="site-nav admin-site-nav">
    <div class="nav-inner">

      <a class="brand" href="{{ route('listing') }}">
        <span class="brand-mark admin-brand-mark" aria-hidden="true">
          <img src="{{ asset('uploads/logo-desa-maor.png') }}" alt="" class="brand-logo admin-brand-logo">
        </span>

        <span class="brand-text">
          <strong>Panel Admin</strong>
          <small>{{ $desa['nama'] }}</small>
        </span>
      </a>
      <nav class="nav-links admin-header-links" aria-label="Navigasi admin">

        @if (auth('admin')->user()?->role === 'superadmin')
          <a href="{{ route('admin_accounts') }}" class="admin-web-link">
            Kelola Admin
          </a>
        @endif

        <a href="{{ route('listing') }}" class="admin-web-link">
          Lihat Web Utama &rarr;
        </a>

        <a href="{{ route('admin_logout') }}" class="admin-logout-link">
          Logout
        </a>

      </nav>
    </div>
  </header>

  <main class="profil-main admin-main">
    <h1 class="admin-header-title">
      Sistem Informasi Manajemen Desa
    </h1>

    @if ($errors->any())
      <div style="
                                                            margin: 0 0 1.5rem;
                                                            padding: 1rem 1.25rem;
                                                            border: 1px solid #dc2626;
                                                            border-radius: 8px;
                                                            background: #fef2f2;
                                                            color: #991b1b;
                                                          ">
        <strong>Data belum berhasil disimpan:</strong>

        <ul style="margin: 0.75rem 0 0; padding-left: 1.25rem;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if (session('success'))
      <div style="
                                                            margin: 0 0 1.5rem;
                                                            padding: 1rem 1.25rem;
                                                            border: 1px solid #16a34a;
                                                            border-radius: 8px;
                                                            background: #f0fdf4;
                                                            color: #166534;
                                                          ">
        {{ session('success') }}
      </div>
    @endif

    <div class="admin-grid">

      <!-- FORM BERITA -->
      <div class="admin-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-news"></use>
          </svg>

          <span>Publikasi Berita Baru</span>
        </h2>
        <form class="admin-form" method="POST" action="{{ route('admin_store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="jenis_form" value="berita">

          <div class="form-group">
            <label>Judul Berita</label>
            <input type="text" name="judul" class="form-control" required placeholder="Cth: Kerja Bakti Rutin...">
          </div>

          <div class="form-group">
            <label>Ringkasan Singkat (Cuplikan)</label>
            <textarea name="ringkasan" class="form-control" rows="2" required
              placeholder="Tulis sedikit inti berita..."></textarea>
          </div>
          <div class="form-group">
            <label>Isi Berita Lengkap</label>

            <div class="admin-rich-text-editor" data-rich-text-editor data-input="#berita-isi"
              data-placeholder="Tulis seluruh isi berita di sini...">

              <textarea id="berita-isi" name="isi" hidden>{{ old('isi') }}</textarea>

              <div data-rich-text-area></div>
            </div>

            <small>
              Gunakan toolbar untuk membuat subjudul, tulisan tebal,
              daftar, kutipan, atau tautan.
            </small>
          </div>

          <div class="form-group">
            <label>Foto / Thumbnail</label>

            <div class="admin-image-editor" data-image-editor>

              <div class="admin-image-preview admin-image-preview--landscape">
                <img data-image-preview alt="Preview foto berita" hidden>

                <div class="admin-image-placeholder" data-image-placeholder>

                  <svg class="admin-placeholder-icon" aria-hidden="true">
                    <use href="#icon-image"></use>
                  </svg>

                  <p>Belum ada foto dipilih</p>

                </div>
              </div>

              <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*"
                data-image-input>

              <button type="button" class="admin-remove-photo-button" data-image-remove hidden>
                Batalkan Foto
              </button>

            </div>
          </div>

          <button type="submit" class="btn-submit btn-news">Upload & Publikasikan Berita</button>
        </form>
      </div>

      <!-- FORM STATISTIK DESA -->
      <div class="admin-card">

        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-chart"></use>
          </svg>

          <span>Kelola Statistik Desa</span>
        </h2>

        <form class="admin-form" method="POST" action="{{ route('admin_store') }}">

          @csrf

          <input type="hidden" name="jenis_form" value="statistik">

          <input type="hidden" name="statistik_id" value="{{ old(
  'statistik_id',
  $statistik['id'] ?? ''
) }}">

          <div class="form-group">
            <label for="tanggal-data">
              Tanggal Data
            </label>

            <input type="date" id="tanggal-data" name="tanggal_data" class="form-control" value="{{ old(
  'tanggal_data',
  $statistik['tanggal_data'] ?? ''
) }}" required>

            <small>
              Tanggal ini ditampilkan pada keterangan di bawah
              jumlah total penduduk.
            </small>
          </div>

          <div class="grid-2-col">

            <div class="form-group">
              <label for="total-penduduk">
                Total Penduduk
              </label>

              <input type="number" id="total-penduduk" name="total_penduduk" class="form-control" min="0" value="{{ old(
  'total_penduduk',
  $statistik['total_penduduk'] ?? ''
) }}" required>
            </div>

            <div class="form-group">
              <label for="jumlah-laki-laki">
                Laki-laki
              </label>

              <input type="number" id="jumlah-laki-laki" name="laki_laki" class="form-control" min="0" value="{{ old(
  'laki_laki',
  $statistik['laki_laki'] ?? ''
) }}" required>
            </div>

          </div>

          <div class="grid-2-col">

            <div class="form-group">
              <label for="jumlah-perempuan">
                Perempuan
              </label>

              <input type="number" id="jumlah-perempuan" name="perempuan" class="form-control" min="0" value="{{ old(
  'perempuan',
  $statistik['perempuan'] ?? ''
) }}" required>
            </div>

            <div class="form-group">
              <label for="jumlah-kk">
                Kepala Keluarga
              </label>

              <input type="number" id="jumlah-kk" name="jumlah_kk" class="form-control" min="0" value="{{ old(
  'jumlah_kk',
  $statistik['jumlah_kk'] ?? ''
) }}" required>
            </div>

          </div>

          <div class="form-group">
            <label for="jumlah-rumah-tangga">
              Jumlah Rumah Tangga
            </label>

            <input type="number" id="jumlah-rumah-tangga" name="jumlah_rumah_tangga" class="form-control" min="0" value="{{ old(
  'jumlah_rumah_tangga',
  $statistik['jumlah_rumah_tangga'] ?? ''
) }}" required>
          </div>

          <small>
            Total penduduk harus sama dengan jumlah
            laki-laki ditambah perempuan.
          </small>

          <button type="submit" class="btn-submit">

            Simpan Statistik Desa
          </button>

        </form>

      </div>

      <!-- KARTU KANAN: FORM POI (TITIK PETA) -->
      <div class="admin-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-location"></use>
          </svg>

          <span>Tambah Titik Peta (POI)</span>
        </h2>
        <form class="admin-form" method="POST" action="{{ route('admin_store') }}">
          @csrf
          <input type="hidden" name="jenis_form" value="poi">

          <div class="form-group">
            <label>Nama Lokasi / Fasilitas</label>
            <input type="text" name="nama" class="form-control" required placeholder="Cth: Balai RW 03...">
          </div>

          <div class="form-group">
            <label>Kategori Tempat</label>
            <select name="kategori" class="form-control" required>
              <option value="" disabled selected>-- Pilih Kategori --</option>
              <option value="Pemerintahan">Pemerintahan</option>
              <option value="Peribadatan">Peribadatan</option>
              <option value="Pendidikan">Pendidikan</option>
              <option value="Kesehatan">Kesehatan</option>
              <option value="Pertanian">Pertanian</option>
              <option value="Pengairan">Pengairan</option>
              <option value="Usaha Warga">Usaha Warga</option>
            </select>
          </div>

          <div class="form-group">
            <label>Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-control" rows="3" required
              placeholder="Jelaskan fungsi atau detail lokasi ini..."></textarea>
          </div>

          <div class="form-group">

            <label>Pilih Titik Lokasi pada Peta</label>

            <p class="admin-map-help">
              Klik lokasi yang diinginkan pada peta.
              Penanda dapat digeser apabila posisinya belum tepat.
            </p>

            <div id="admin-poi-map" class="admin-map-picker" data-map-picker data-lat-input="#poi-lat"
              data-lng-input="#poi-lng" data-default-lat="{{ $desa['peta_pusat']['lat'] }}"
              data-default-lng="{{ $desa['peta_pusat']['lng'] }}" aria-label="Pilih titik lokasi baru"></div>

          </div>

          <div class="grid-2-col">

            <div class="form-group">
              <label for="poi-lat">Latitude (Otomatis)</label>

              <input type="number" step="any" id="poi-lat" name="lat" class="form-control" required readonly
                placeholder="Klik lokasi pada peta">
            </div>

            <div class="form-group">
              <label for="poi-lng">Longitude (Otomatis)</label>

              <input type="number" step="any" id="poi-lng" name="lng" class="form-control" required readonly
                placeholder="Klik lokasi pada peta">
            </div>

          </div>

          <button type="submit" class="btn-submit btn-poi">Tambahkan ke Peta Web</button>
        </form>
      </div>
      <!-- KARTU TAMBAHAN: FORM AGENDA -->
      <div class="admin-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-calendar"></use>
          </svg>

          <span>Tambah Agenda Desa</span>
        </h2>
        <form class="admin-form" method="POST" action="{{ route('admin_store') }}">
          @csrf
          <input type="hidden" name="jenis_form" value="agenda">

          <div class="form-group">
            <label>Nama Kegiatan</label>
            <input type="text" name="judul" class="form-control" required placeholder="Cth: Kerja Bakti Rutin...">
          </div>

          <div class="grid-2-col">
            <div class="form-group">
              <label>Tanggal Kegiatan</label>
              <!-- Input type date akan otomatis memunculkan kalender bawaan browser -->
              <input type="date" name="tanggal" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Waktu Pelaksanaan</label>
              <input type="text" name="waktu" class="form-control" required placeholder="Cth: 08:00 WIB - Selesai">
            </div>
          </div>

          <div class="form-group">
            <label>Lokasi Acara</label>
            <input type="text" name="lokasi" class="form-control" required placeholder="Cth: Balai Desa Maor">
          </div>

          <button type="submit" class="btn-submit">
            Simpan Agenda
          </button>
        </form>
      </div>

      <!-- KARTU TAMBAHAN: FORM STRUKTUR ORGANISASI -->
      <div class="admin-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-user"></use>
          </svg>

          <span>Tambah Struktur Organisasi</span>
        </h2>

        <form class="admin-form" method="POST" action="{{ route('admin_store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="jenis_form" value="struktur">

          <div class="grid-2-col">

            <div class="form-group">
              <label>Nama Lengkap</label>
              <input type="text" name="nama" class="form-control" required placeholder="Cth: Sidik">
            </div>

            <div class="form-group">
              <label>Jabatan</label>
              <input type="text" name="jabatan" class="form-control" required placeholder="Cth: Kepala Desa">
            </div>

          </div>

          <div class="form-group">
            <label>Urutan Tampilan</label>
            <input type="number" name="urutan" class="form-control" value="1" min="1" required>

            <small>
              Angka yang lebih kecil akan tampil lebih dahulu.
            </small>
          </div>

          <div class="form-group">
            <label>Foto Perangkat Desa</label>

            <div class="admin-image-editor" data-image-editor>

              <div class="admin-image-preview admin-image-preview--portrait">
                <img data-image-preview alt="Preview foto perangkat desa" hidden>

                <div class="admin-image-placeholder" data-image-placeholder>

                  <svg class="admin-placeholder-icon" aria-hidden="true">
                    <use href="#icon-user"></use>
                  </svg>

                  <p>Belum ada foto dipilih</p>

                </div>
              </div>

              <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*"
                data-image-input>

              <button type="button" class="admin-remove-photo-button" data-image-remove hidden>
                Batalkan Foto
              </button>

            </div>
          </div>

          <button type="submit" class="btn-submit">
            Simpan Perangkat Desa
          </button>

        </form>
      </div>

      <!-- KARTU TAMBAHAN: FORM PRODUK UMKM -->
      <div class="admin-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-store"></use>
          </svg>

          <span>Tambah Produk UMKM</span>
        </h2>

        <form class="admin-form" method="POST" action="{{ route('admin_store') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="jenis_form" value="umkm">

          <div class="grid-2-col">

            <div class="form-group">
              <label>Nama Produk</label>
              <input type="text" name="nama_produk" class="form-control" required placeholder="Cth: Keripik Pisang">
            </div>

            <div class="form-group">
              <label>Nama Usaha</label>
              <input type="text" name="nama_usaha" class="form-control" required placeholder="Cth: UMKM Berkah Maor">
            </div>

          </div>

          <div class="form-group">
            <label>Kategori Produk</label>

            <select name="kategori" class="form-control" required>
              <option value="" disabled selected>
                -- Pilih Kategori --
              </option>

              <option value="Makanan">Makanan</option>
              <option value="Minuman">Minuman</option>
              <option value="Kerajinan">Kerajinan</option>
              <option value="Pertanian">Pertanian</option>
              <option value="Jasa">Jasa</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <div class="form-group">
            <label>Deskripsi Produk</label>
            <textarea name="deskripsi" class="form-control" rows="4"
              placeholder="Jelaskan produk secara singkat..."></textarea>
          </div>

          <div class="form-group">
            <label>Nomor WhatsApp</label>
            <input type="text" name="nomor_wa" class="form-control" required placeholder="Cth: 6281234567890">

            <small>
              Gunakan format 62, bukan angka 0 di bagian depan.
            </small>
          </div>

          <div class="form-group">
            <label>Alamat Usaha</label>
            <textarea name="alamat" class="form-control" rows="3" required
              placeholder="Cth: Dusun Maor, Desa Maor..."></textarea>
          </div>

          <div class="form-group">
            <label>Link Google Maps</label>
            <input type="url" name="maps_url" class="form-control" required placeholder="https://maps.google.com/...">
          </div>

          <div class="form-group">
            <label>Foto Produk</label>

            <div class="admin-image-editor" data-image-editor>

              <div class="admin-image-preview admin-image-preview--product">
                <img data-image-preview alt="Preview foto produk" hidden>

                <div class="admin-image-placeholder" data-image-placeholder>

                  <svg class="admin-placeholder-icon" aria-hidden="true">
                    <use href="#icon-store"></use>
                  </svg>

                  <p>Belum ada foto produk dipilih</p>

                </div>
              </div>

              <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/*"
                data-image-input>

              <button type="button" class="admin-remove-photo-button" data-image-remove hidden>
                Batalkan Foto
              </button>

            </div>
          </div>

          <div class="form-group">
            <label>Status Produk</label>

            <select name="status" class="form-control" required>
              <option value="aktif" selected>Aktif</option>
              <option value="nonaktif">Nonaktif</option>
            </select>
          </div>

          <button type="submit" class="btn-submit">
            Simpan Produk UMKM
          </button>

        </form>
      </div>

      <!-- DAFTAR STRUKTUR ORGANISASI -->
      <section class="admin-card admin-list-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-users"></use>
          </svg>

          <span>Daftar Struktur Organisasi</span>
        </h2>

        @if($daftar_struktur)

          <div style="overflow-x: auto;">
            <table style="
                                                                width: 100%;
                                                                min-width: 800px;
                                                                border-collapse: collapse;
                                                              ">

              <thead>
                <tr>
                  <th style="padding: 1rem; text-align: left;">Urutan</th>
                  <th style="padding: 1rem; text-align: left;">Foto</th>
                  <th style="padding: 1rem; text-align: left;">Nama</th>
                  <th style="padding: 1rem; text-align: left;">Jabatan</th>
                  <th style="padding: 1rem; text-align: center;">Aksi</th>
                </tr>
              </thead>

              <tbody>
                @foreach($daftar_struktur as $item_struktur)
                  <tr>

                    <td style="padding: 1rem;">
                      {{ $item_struktur["urutan"] }}
                    </td>

                    <td style="padding: 1rem;">

                      @if($item_struktur["foto"] && $item_struktur["foto"] != "default.jpg")

                        <img src="{{ asset('uploads/' . $item_struktur['foto']) }}" alt="{{ $item_struktur['nama'] }}"
                          style="
                                                                                                                                                                                          width: 65px;
                                                                                                                                                                                          height: 80px;
                                                                                                                                                                                          object-fit: cover;
                                                                                                                                                                                          object-position: center top;
                                                                                                                                                                                          border-radius: 7px;
                                                                                                                                                                                        ">

                      @else

                        <span style="color: var(--muted-sage);">
                          Belum ada foto
                        </span>

                      @endif

                    </td>

                    <td style="padding: 1rem;">
                      <strong>{{ $item_struktur["nama"] }}</strong>
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_struktur["jabatan"] }}
                    </td>

                    <td class="admin-action-cell">

                      <div class="admin-action-group">

                        <a href="{{ route('admin_edit_struktur', $item_struktur['id']) }}" class="admin-edit-button">
                          Edit
                        </a>

                        <form class="admin-delete-form" action="{{ route('admin_hapus_struktur', $item_struktur['id']) }}"
                          method="POST"
                          onsubmit="return confirm(
                                                                                                                                  'Apakah Anda yakin ingin menghapus perangkat desa ini?'
                                                                                                                                );">
                          @csrf
                          <button class="admin-delete-button" type="submit">
                            Hapus
                          </button>
                        </form>

                      </div>

                    </td>

                  </tr>

                @endforeach
              </tbody>

            </table>
          </div>

        @else

          <p style="color: var(--muted-sage);">
            Belum ada data struktur organisasi.
          </p>

        @endif

      </section>

      <!-- DAFTAR BERITA YANG SUDAH TERSIMPAN -->
      <section class="admin-card admin-list-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-list"></use>
          </svg>

          <span>Daftar Berita Tersimpan</span>
        </h2>

        @if($daftar_berita)
          <div style="overflow-x: auto;">
            <table style="
                                                                width: 100%;
                                                                min-width: 700px;
                                                                border-collapse: collapse;
                                                              ">
              <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                  <th style="padding: 1rem; text-align: left;">No.</th>
                  <th style="padding: 1rem; text-align: left;">Judul</th>
                  <th style="padding: 1rem; text-align: left;">Tanggal</th>
                  <th style="padding: 1rem; text-align: left;">Gambar</th>
                  <th style="padding: 1rem; text-align: center;">Aksi</th>
                </tr>
              </thead>

              <tbody>
                @foreach($daftar_berita as $item)
                  <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">
                    <td style="padding: 1rem;">
                      {{ $loop->iteration }}
                    </td>

                    <td style="padding: 1rem;">
                      <strong>{{ $item["judul"] }}</strong>
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item["tanggal"] }}
                    </td>

                    <td style="padding: 1rem;">
                      @if($item["gambar"])
                        <img src="{{ asset('uploads/' . $item['gambar']) }}" alt="{{ $item['judul'] }}"
                          style="
                                                                                                                                                                                          width: 80px;
                                                                                                                                                                                          height: 55px;
                                                                                                                                                                                          object-fit: cover;
                                                                                                                                                                                          border-radius: 6px;
                                                                                                                                                                                        ">
                      @else
                        Tidak ada gambar
                      @endif
                    </td>

                    <td class="admin-action-cell">

                      <div class="admin-action-group">

                        <a href="{{ route('admin_edit_berita', $item['id']) }}" class="admin-edit-button">
                          Edit
                        </a>

                        <form class="admin-delete-form" action="{{ route('admin_hapus_berita', $item['id']) }}"
                          method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus berita ini?');">
                          @csrf
                          <button class="admin-delete-button" type="submit">
                            Hapus
                          </button>
                        </form>

                      </div>

                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        @else
          <p style="color: var(--muted-sage);">
            Belum ada berita yang tersimpan.
          </p>
        @endif
      </section>

      <!-- DAFTAR AGENDA YANG SUDAH TERSIMPAN -->
      <section class="admin-card admin-list-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-calendar"></use>
          </svg>

          <span>Daftar Agenda Tersimpan</span>
        </h2>

        @if($daftar_agenda)
          <div style="overflow-x: auto;">
            <table style="
                                                                width: 100%;
                                                                min-width: 850px;
                                                                border-collapse: collapse;
                                                              ">
              <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">
                  <th style="padding: 1rem; text-align: left;">
                    No.
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Nama Kegiatan
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Tanggal
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Waktu
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Lokasi
                  </th>

                  <th style="padding: 1rem; text-align: center;">
                    Aksi
                  </th>
                </tr>
              </thead>

              <tbody>
                @foreach($daftar_agenda as $item_agenda)
                  <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                    <td style="padding: 1rem;">
                      {{ $loop->iteration }}
                    </td>

                    <td style="padding: 1rem;">
                      <strong>
                        {{ $item_agenda["judul"] }}
                      </strong>
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_agenda["tanggal"] }}
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_agenda["waktu"] }}
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_agenda["lokasi"] }}
                    </td>

                    <td class="admin-action-cell">

                      <div class="admin-action-group">

                        <a href="{{ route('admin_edit_agenda', $item_agenda['id']) }}" class="admin-edit-button">
                          Edit
                        </a>

                        <form class="admin-delete-form" action="{{ route('admin_hapus_agenda', $item_agenda['id']) }}"
                          method="POST"
                          onsubmit="return confirm(
                                                                                                                            'Apakah kamu yakin ingin menghapus agenda ini?'
                                                                                                                          );">
                          @csrf
                          <button class="admin-delete-button" type="submit">
                            Hapus
                          </button>
                        </form>

                      </div>

                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        @else
          <p style="color: var(--muted-sage);">
            Belum ada agenda yang tersimpan.
          </p>
        @endif
      </section>

      <!-- DAFTAR TITIK PETA YANG SUDAH TERSIMPAN -->
      <section class="admin-card admin-list-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-location"></use>
          </svg>

          <span>Daftar Titik Peta Tersimpan</span>
        </h2>

        @if($daftar_poi)
          <div style="overflow-x: auto;">
            <table style="
                                                                width: 100%;
                                                                min-width: 1050px;
                                                                border-collapse: collapse;
                                                              ">
              <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">

                  <th style="padding: 1rem; text-align: left;">
                    No.
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Nama Lokasi
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Kategori
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Deskripsi
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Latitude
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Longitude
                  </th>

                  <th style="padding: 1rem; text-align: center;">
                    Aksi
                  </th>

                </tr>
              </thead>

              <tbody>
                @foreach($daftar_poi as $item_poi)
                  <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                    <td style="padding: 1rem;">
                      {{ $loop->iteration }}
                    </td>

                    <td style="padding: 1rem;">
                      <strong>
                        {{ $item_poi["nama"] }}
                      </strong>
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_poi["kategori"] }}
                    </td>

                    <td
                      style="
                                                                                                                                    padding: 1rem;
                                                                                                                                    min-width: 240px;
                                                                                                                                    line-height: 1.6;
                                                                                                                                  ">
                      {{ $item_poi["deskripsi"] }}
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_poi["lat"] }}
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_poi["lng"] }}
                    </td>

                    <td class="admin-action-cell">

                      <div class="admin-action-group">

                        <a href="{{ route('admin_edit_poi', $item_poi['id']) }}" class="admin-edit-button">
                          Edit
                        </a>

                        <form class="admin-delete-form" action="{{ route('admin_hapus_poi', $item_poi['id']) }}"
                          method="POST"
                          onsubmit="return confirm(
                                                                                                                            'Apakah Anda yakin ingin menghapus titik peta ini?'
                                                                                                                          );">
                          @csrf
                          <button class="admin-delete-button" type="submit">
                            Hapus
                          </button>
                        </form>

                      </div>

                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

        @else
          <p style="color: var(--muted-sage);">
            Belum ada titik peta yang tersimpan.
          </p>
        @endif
      </section>

      <!-- DAFTAR PRODUK UMKM YANG SUDAH TERSIMPAN -->
      <section class="admin-card admin-list-card">
        <h2 class="admin-card-title">
          <svg class="admin-ui-icon" aria-hidden="true">
            <use href="#icon-store"></use>
          </svg>

          <span>Daftar Produk UMKM Tersimpan</span>
        </h2>

        @if($daftar_umkm)
          <div style="overflow-x: auto;">

            <table style="
                                                                width: 100%;
                                                                min-width: 1100px;
                                                                border-collapse: collapse;
                                                              ">

              <thead>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.2);">

                  <th style="padding: 1rem; text-align: left;">
                    No.
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Produk
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Nama Usaha
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Kategori
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    WhatsApp
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Status
                  </th>

                  <th style="padding: 1rem; text-align: left;">
                    Gambar
                  </th>

                  <th style="padding: 1rem; text-align: center;">
                    Aksi
                  </th>

                </tr>
              </thead>

              <tbody>

                @foreach($daftar_umkm as $item_umkm)

                  <tr style="border-bottom: 1px solid rgba(255,255,255,0.08);">

                    <td style="padding: 1rem;">
                      {{ $loop->iteration }}
                    </td>

                    <td style="padding: 1rem; min-width: 180px;">
                      <strong>
                        {{ $item_umkm["nama_produk"] }}
                      </strong>
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_umkm["nama_usaha"] }}
                    </td>

                    <td style="padding: 1rem;">
                      {{ $item_umkm["kategori"] }}
                    </td>

                    <td style="padding: 1rem;">
                      <a href="https://wa.me/{{ $item_umkm['nomor_wa'] }}" target="_blank" rel="noopener noreferrer"
                        class="admin-whatsapp-link">
                        {{ $item_umkm["nomor_wa"] }}
                      </a>
                    </td>

                    <td style="padding: 1rem;">
                      @if($item_umkm["status"] == "aktif")
                        <span class="admin-status-badge admin-status-badge--active">
                          Aktif
                        </span>
                      @else
                        <span class="admin-status-badge admin-status-badge--inactive">
                          Nonaktif
                        </span>
                      @endif
                    </td>

                    <td style="padding: 1rem;">
                      @if($item_umkm["gambar"])
                        <img src="{{ asset('uploads/' . $item_umkm['gambar']) }}" alt="{{ $item_umkm['nama_produk'] }}"
                          style="
                                                                                                                                                                                                  width: 85px;
                                                                                                                                                                                                  height: 70px;
                                                                                                                                                                                                  object-fit: cover;
                                                                                                                                                                                                  border-radius: 7px;
                                                                                                                                                                                                ">
                      @else
                        Tidak ada gambar
                      @endif
                    </td>

                    <td class="admin-action-cell">

                      <div class="admin-action-group">

                        <a href="{{ route('admin_edit_umkm', $item_umkm['id']) }}" class="admin-edit-button">
                          Edit
                        </a>

                        <form class="admin-delete-form" action="{{ route('admin_hapus_umkm', $item_umkm['id']) }}"
                          method="POST"
                          onsubmit="return confirm(
                                                                                                                                'Apakah Anda yakin ingin menghapus produk UMKM ini?'
                                                                                                                              );">
                          @csrf
                          <button class="admin-delete-button" type="submit">
                            Hapus
                          </button>
                        </form>

                      </div>

                    </td>

                  </tr>

                @endforeach

              </tbody>
            </table>

          </div>

        @else

          <p style="color: var(--muted-sage);">
            Belum ada produk UMKM yang tersimpan.
          </p>

        @endif

      </section>

    </div>
    <!-- AKHIR ADMIN GRID -->

  </main>

  <script src="{{ asset('js/admin-image-preview.js') }}" defer></script>

  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

  <script src="{{ asset('js/admin-rich-text-editor.js') }}"></script>

</body>

</html>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="{{ asset('js/admin-map-picker.js') }}"></script>