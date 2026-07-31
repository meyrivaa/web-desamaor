<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Edit Berita — {{ $desa['nama'] }}</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link
    href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Work+Sans:wght@400;500;600&family=IBM+Plex+Mono:wght@400;500&display=swap"
    rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

  <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

  <style>
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
      min-height: 300px;
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

  <main class="admin-edit-page">

    <section class="admin-edit-card">

      <a href="{{ route('admin_dashboard') }}" class="admin-edit-back">
        ← Kembali ke Dashboard
      </a>

      <span class="admin-edit-label">
        Manajemen Berita
      </span>

      <h1>Edit Berita</h1>

      <p class="admin-edit-description">
        Ubah informasi berita melalui formulir berikut.
      </p>

      @if ($errors->any())
        <div class="admin-edit-error">
          <strong>Perubahan belum berhasil disimpan:</strong>

          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" enctype="multipart/form-data" class="admin-edit-form"
        action="{{ route('admin_update_berita', $item['id']) }}">
        @csrf

        <div class="admin-edit-field">
          <label for="judul">
            Judul Berita
          </label>

          <input type="text" id="judul" name="judul" value="{{ $item['judul'] }}" required>
        </div>

        <div class="admin-edit-field">
          <label for="tanggal">
            Tanggal Berita
          </label>

          <input type="text" id="tanggal" name="tanggal" value="{{ $item['tanggal'] }}" required>

          <small>
            Contoh: 25 Juli 2026
          </small>
        </div>

        <div class="admin-edit-field">
          <label for="ringkasan">
            Ringkasan
          </label>

          <textarea id="ringkasan" name="ringkasan" rows="4" required>{{ $item['ringkasan'] }}</textarea>
        </div>

        <div class="admin-edit-field">
          <label for="berita-isi">
            Isi Berita
          </label>

          <div class="admin-rich-text-editor" data-rich-text-editor data-input="#berita-isi"
            data-placeholder="Tulis seluruh isi berita di sini...">

            <textarea id="berita-isi" name="isi" hidden>{{ old('isi', $item['isi']) }}</textarea>

            <div data-rich-text-area></div>
          </div>

          <small>
            Gunakan toolbar untuk membuat subjudul, tulisan tebal,
            daftar, kutipan, atau tautan.
          </small>
        </div>

        <div class="admin-edit-field">
          <label>Preview Gambar</label>

          <div class="admin-image-editor" data-image-editor>

            <div class="admin-image-preview admin-image-preview--landscape">

              <img data-image-preview @if($item["gambar"] && $item["gambar"] != "default.jpg")
              src="{{ asset('uploads/' . $item['gambar']) }}" alt="{{ $item['judul'] }}" @else hidden
                alt="Preview gambar berita" @endif>

              <div class="admin-image-placeholder" data-image-placeholder @if(
                $item["gambar"] && $item["gambar"]
                != "default.jpg"
              ) hidden @endif>
                <span>📰</span>
                <p>Berita belum memiliki gambar</p>
              </div>

            </div>

            <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp,image/*" data-image-input>

            <input type="hidden" name="hapus_gambar" value="0" data-image-delete>

            <button type="button" class="admin-remove-photo-button" data-image-remove @if(
              !$item["gambar"] ||
              $item["gambar"] == "default.jpg"
            ) hidden @endif>
              Hapus Gambar
            </button>

            <small>
              Pilih gambar baru untuk mengganti gambar lama.
            </small>

          </div>
        </div>

        <div class="admin-edit-actions">

          <a href="{{ route('admin_dashboard') }}" class="admin-cancel-button">
            Batal
          </a>

          <button type="submit" class="admin-save-button">
            Simpan Perubahan
          </button>

        </div>

      </form>

    </section>

  </main>

  <script src="{{ asset('js/admin-image-preview.js') }}" defer></script>

  <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

  <script src="{{ asset('js/admin-rich-text-editor.js') }}"></script>

</body>

</html>