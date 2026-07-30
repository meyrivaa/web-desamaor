# Checklist Pengujian Website Desa Maor

## Pengujian otomatis

```powershell
php artisan test
```

## Halaman publik

- [ ] `/listing` terbuka dan video/gambar tampil.
- [ ] Statistik kunjungan bertambah.
- [ ] Profil dan visi-misi tampil.
- [ ] Struktur organisasi tampil sesuai urutan.
- [ ] Daftar dan detail berita dapat dibuka.
- [ ] Infografis tampil.
- [ ] UMKM aktif tampil, tombol WhatsApp dan Maps bekerja.
- [ ] Peta Leaflet dan seluruh titik POI tampil.
- [ ] Menu desktop, tablet, dan ponsel bekerja.

## Admin

- [ ] Password salah ditolak.
- [ ] Password benar membuka dashboard.
- [ ] Tambah, edit, hapus berita.
- [ ] Tambah, edit, hapus infografis.
- [ ] Tambah, edit, hapus agenda.
- [ ] Tambah, edit, hapus titik peta.
- [ ] Tambah, edit, hapus struktur organisasi.
- [ ] Tambah, edit, hapus UMKM.
- [ ] Pratinjau dan penggantian gambar bekerja.
- [ ] Logout kembali ke halaman publik.

## Produksi

- [ ] `APP_ENV=production`.
- [ ] `APP_DEBUG=false`.
- [ ] `APP_URL` sesuai domain HTTPS.
- [ ] `ADMIN_PASSWORD` telah diganti.
- [ ] `POI_API_KEY` telah diganti.
- [ ] MySQL terhubung.
- [ ] `storage`, `bootstrap/cache`, dan `public/uploads` dapat ditulis.
