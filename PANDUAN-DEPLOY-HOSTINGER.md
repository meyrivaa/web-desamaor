# Panduan Deploy Website Desa Maor ke Hostinger Shared Hosting

## A. Siapkan proyek di komputer

Pastikan versi PHP terminal minimal 8.3, lalu jalankan dari folder proyek:

```powershell
composer install --no-dev --optimize-autoloader
php artisan optimize:clear
php artisan test
```

Folder `vendor` akan terbentuk. Upload folder tersebut bersama proyek apabila paket Hostinger Anda tidak menyediakan Composer/SSH.

## B. Atur versi PHP di hPanel

Pilih PHP 8.3 atau 8.4 dan aktifkan ekstensi PHP yang diperlukan Laravel, terutama PDO MySQL, Mbstring, OpenSSL, Fileinfo, Ctype, XML, dan Tokenizer.

## C. Buat database MySQL

Di hPanel, buat database dan pengguna MySQL. Catat:

- host database;
- nama database;
- username;
- password.

Ada dua cara memasukkan tabel dan data:

### Pilihan 1 — Terminal/SSH

Dari root proyek:

```bash
php artisan migrate --seed --force
```

### Pilihan 2 — phpMyAdmin

Impor file berikut melalui menu **Import**:

```text
database/maor_mysql.sql
```

File tersebut sudah berisi struktur tabel dan semua data dari proyek Python.

## D. Buat `.env` produksi

Salin `.env.example` menjadi `.env`, lalu isi:

```env
APP_NAME="Website Desa Maor"
APP_ENV=production
APP_KEY=base64:HASIL_KEY_ANDA
APP_DEBUG=false
APP_URL=https://domain-anda.com
APP_TIMEZONE=Asia/Jakarta
APP_LOCALE=id
APP_FALLBACK_LOCALE=id

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=nama_user
DB_PASSWORD=password_database

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

ADMIN_PASSWORD=ganti-dengan-password-admin-yang-kuat
POI_API_KEY=ganti-dengan-api-key-yang-kuat
```

Untuk membuat `APP_KEY`, jalankan:

```powershell
php artisan key:generate
```

## E. Susunan folder hosting

Cara yang disarankan:

1. Upload folder proyek ke luar `public_html`, misalnya:
   `domains/domain-anda.com/laravel-desa-maor`
2. Arahkan document root domain ke:
   `laravel-desa-maor/public`

Apabila document root tidak dapat diubah:

1. Taruh proyek di luar `public_html`.
2. Salin seluruh isi folder `public` ke `public_html`.
3. Ubah dua path pada `public_html/index.php` agar menunjuk ke folder proyek, contohnya:

```php
require __DIR__.'/../laravel-desa-maor/vendor/autoload.php';
$app = require_once __DIR__.'/../laravel-desa-maor/bootstrap/app.php';
```

Sesuaikan jumlah `../` dengan posisi folder sebenarnya.

## F. Perintah akhir

Jika tersedia Terminal/SSH:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Pastikan folder berikut dapat ditulis oleh server:

```text
storage
bootstrap/cache
public/uploads
```

Permission yang lazim digunakan adalah 775, tetapi ikuti kebijakan server Hostinger Anda.

## G. Pemeriksaan setelah online

Periksa halaman publik, peta, gambar/video, login admin, serta satu percobaan tambah–edit–hapus untuk setiap modul. Jangan biarkan password awal `adminmaor123` dipakai di website produksi.
