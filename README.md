# Website Desa Maor — Laravel 13

Versi Laravel dari proyek Flask/Python Website Desa Maor. CSS, JavaScript, gambar, video, isi database, serta susunan halaman asli dipertahankan agar tampilan dan alurnya tetap sedekat mungkin dengan proyek sebelumnya.

## Isi yang sudah dipindahkan

- Halaman publik: Beranda, Profil, Struktur Organisasi, Berita, Detail Berita, UMKM, Infografis, dan Peta Desa.
- Login dan dashboard admin.
- Tambah, edit, hapus: berita, infografis, agenda, titik peta, struktur organisasi, dan UMKM.
- Statistik kunjungan harian, mingguan, bulanan, dan total.
- Upload, penggantian, pratinjau, dan penghapusan gambar.
- Database SQLite lokal berisi data proyek lama.
- Migration, seeder, dan berkas SQL MySQL untuk Hostinger.

## Menjalankan di Windows / VS Code

Cara termudah: klik dua kali `1-INSTAL-DAN-CEK.bat`, kemudian `2-JALANKAN-WEB.bat`.

Atau jalankan manual dari Terminal VS Code:

```powershell
composer install
php artisan optimize:clear
php artisan test
php artisan serve
```

Buka:

- Website: `http://127.0.0.1:8000`
- Admin: `http://127.0.0.1:8000/admin`
- Password awal: `adminmaor123`

Database lokal sudah tersedia di `database/database.sqlite`, jadi pemakaian pertama tidak perlu menjalankan migrate.

## Persyaratan

- PHP 8.3 atau lebih baru.
- Composer 2.
- Ekstensi PHP umum Laravel: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, Fileinfo, dan SQLite untuk mode lokal.

## Deployment

Ikuti `PANDUAN-DEPLOY-HOSTINGER.md`. Sebelum produksi, wajib mengganti `ADMIN_PASSWORD`, `POI_API_KEY`, `APP_URL`, konfigurasi database, serta mengatur `APP_DEBUG=false`.
