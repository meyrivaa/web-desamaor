<?php
namespace Database\Seeders; use Illuminate\Database\Seeder; use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder { public function run():void {
        DB::table('berita')->insertOrIgnore([
            ['id'=>29, 'judul'=>'Kerja Bakti Bersihkan Embung Desa', 'tanggal'=>'17 Juli 2026', 'ringkasan'=>'Warga Desa Maor bergotong royong membersihkan area embung untuk persiapan musim kemarau.', 'isi'=>'Isi berita lengkap di sini...', 'gambar'=>'default.jpg'],
            ['id'=>30, 'judul'=>'Penyaluran Bantuan Bibit Padi', 'tanggal'=>'15 Juli 2026', 'ringkasan'=>'Pemerintah Desa Maor menyalurkan bantuan bibit padi unggul kepada kelompok tani.', 'isi'=>'Isi berita lengkap di sini...', 'gambar'=>'default.jpg'],
            ['id'=>31, 'judul'=>'Posyandu Balita Bulan Juli Berjalan Lancar', 'tanggal'=>'10 Juli 2026', 'ringkasan'=>'Kegiatan posyandu rutin bulan ini dihadiri oleh puluhan balita dan ibu hamil di Polindes.', 'isi'=>'Isi berita lengkap di sini...', 'gambar'=>'default.jpg'],
            ['id'=>33, 'judul'=>'Kerja Bakti', 'tanggal'=>'25 July 2026', 'ringkasan'=>'Kerja bakti rt 3 rw1', 'isi'=>'kerjabakti rt 3 josjis', 'gambar'=>'Cuplikan_layar_2026-07-23_232556.png'],
            ['id'=>34, 'judul'=>'Sosialisasi', 'tanggal'=>'27 July 2026', 'ringkasan'=>'Sosialisasi pupuk', 'isi'=>'Sosialisasi pupuk POC', 'gambar'=>'berita_20260727153224143879_1.monitoring_model_accuracy_value.png'],
            ['id'=>35, 'judul'=>'Sosialisasi', 'tanggal'=>'27 July 2026', 'ringkasan'=>'Sosialisasi TTG', 'isi'=>'-', 'gambar'=>'berita_20260727154828909147_Asah_2025_-_Sesi_Capstone_Briefing_1.png']
        ]);
        DB::table('poi')->insertOrIgnore([
            ['id'=>1, 'nama'=>'Kantor Kepala Desa Maor', 'kategori'=>'Pemerintahan', 'deskripsi'=>'Pusat pelayanan administrasi dan pemerintahan Desa Maor.', 'lat'=>-7.204406966500724, 'lng'=>112.35340342229905],
            ['id'=>2, 'nama'=>'Masjid Desa\' Maor', 'kategori'=>'Peribadatan', 'deskripsi'=>'Masjid utama yang menjadi pusat kegiatan keagamaan warga setempat.', 'lat'=>-7.205148801479981, 'lng'=>112.35316240013985],
            ['id'=>3, 'nama'=>'MI Maor', 'kategori'=>'Pendidikan', 'deskripsi'=>'Madrasah Ibtidaiyah yang melayani pendidikan dasar agama anak-anak.', 'lat'=>-7.205347319005749, 'lng'=>112.35317659401258],
            ['id'=>4, 'nama'=>'SD Negeri Maor', 'kategori'=>'Pendidikan', 'deskripsi'=>'Sekolah dasar negeri yang memfasilitasi belajar mengajar usia dini di desa.', 'lat'=>-7.204453077046238, 'lng'=>112.35311269110177],
            ['id'=>5, 'nama'=>'Embung Desa', 'kategori'=>'Pengairan', 'deskripsi'=>'Sumber penampungan air untuk irigasi persawahan, khususnya saat musim kemarau.', 'lat'=>-7.208761992401299, 'lng'=>112.3494784965776],
            ['id'=>6, 'nama'=>'Polindes Desa Maor', 'kategori'=>'Kesehatan', 'deskripsi'=>'Fasilitas pondok bersalin dan layanan kesehatan dasar desa.', 'lat'=>-7.204192253274142, 'lng'=>112.35324059733296],
            ['id'=>7, 'nama'=>'Tour And Travel Mujahidin', 'kategori'=>'Usaha Warga', 'deskripsi'=>'Biro perjalanan dan layanan transportasi milik warga desa.', 'lat'=>-7.204244921639009, 'lng'=>112.35318431873094]
        ]);
        DB::table('kunjungan')->insertOrIgnore([
            ['id'=>1, 'tanggal'=>'2026-07-21', 'jumlah'=>35],
            ['id'=>36, 'tanggal'=>'2026-07-22', 'jumlah'=>23],
            ['id'=>59, 'tanggal'=>'2026-07-23', 'jumlah'=>29],
            ['id'=>88, 'tanggal'=>'2026-07-24', 'jumlah'=>1],
            ['id'=>89, 'tanggal'=>'2026-07-25', 'jumlah'=>16],
            ['id'=>105, 'tanggal'=>'2026-07-26', 'jumlah'=>6],
            ['id'=>111, 'tanggal'=>'2026-07-27', 'jumlah'=>95],
            ['id'=>206, 'tanggal'=>'2026-07-28', 'jumlah'=>25],
            ['id'=>231, 'tanggal'=>'2026-07-29', 'jumlah'=>45]
        ]);
        DB::table('agenda')->insertOrIgnore([
            ['id'=>1, 'judul'=>'posyandu', 'tanggal'=>'2026-07-30', 'waktu'=>'08:00 - selesai', 'lokasi'=>'polindes']
        ]);
        DB::table('infografis')->insertOrIgnore([
            ['id'=>2, 'judul'=>'Kerja Bakti rt 3', 'gambar'=>'20260725123352_1.bukti_serving.png', 'tanggal'=>'25 July 2026'],
            ['id'=>3, 'judul'=>'posyandu', 'gambar'=>'1.bukti_serving.png', 'tanggal'=>'27 July 2026']
        ]);
        DB::table('struktur_organisasi')->insertOrIgnore([
            ['id'=>1, 'nama'=>'Sidik', 'jabatan'=>'Kepala Desa', 'foto'=>'struktur_20260727150835153492_Cuplikan_layar_2026-07-27_145517.png', 'urutan'=>1],
            ['id'=>2, 'nama'=>'Nama Sekdes', 'jabatan'=>'Sekretaris Desa', 'foto'=>'default.jpg', 'urutan'=>2],
            ['id'=>3, 'nama'=>'Nama', 'jabatan'=>'Kaur Keuangan', 'foto'=>'default.jpg', 'urutan'=>3]
        ]);
        DB::table('umkm')->insertOrIgnore([
            ['id'=>1, 'nama_produk'=>'Keripik Singkong', 'nama_usaha'=>'Keripik lancar jaya', 'kategori'=>'Makanan', 'harga'=>10000, 'satuan'=>'bungkus', 'deskripsi'=>'Keripik enak', 'nomor_wa'=>'6281234567890', 'alamat'=>'Ds. Maor', 'maps_url'=>'https://maps.app.goo.gl/auHFz5YWzcFkQaqz8', 'gambar'=>'umkm_20260726232525_Cuplikan_layar_2026-07-26_225257.png', 'status'=>'aktif', 'tanggal'=>'26 July 2026'],
            ['id'=>3, 'nama_produk'=>'keripik pisang', 'nama_usaha'=>'kripik gedang', 'kategori'=>'Makanan', 'harga'=>7000, 'satuan'=>'bungkus', 'deskripsi'=>'enak manis gurih', 'nomor_wa'=>'6281234567890', 'alamat'=>'ds maor', 'maps_url'=>'https://maps.app.goo.gl/auHFz5YWzcFkQaqz8', 'gambar'=>'umkm_20260727003643_1.bukti_serving.png', 'status'=>'aktif', 'tanggal'=>'27 July 2026']
        ]);
    }
}
