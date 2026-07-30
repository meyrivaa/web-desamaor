-- Database Website Desa Maor - Laravel
-- Dapat diimpor langsung melalui phpMyAdmin Hostinger.
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `migrations` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT, `migration` VARCHAR(255) NOT NULL, `batch` INT NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `migrations` (`migration`,`batch`) VALUES ('2026_07_30_000000_create_desa_maor_tables',1);

DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `judul` VARCHAR(255) NOT NULL, `tanggal` VARCHAR(255) NOT NULL, `ringkasan` TEXT NOT NULL, `isi` LONGTEXT NOT NULL, `gambar` VARCHAR(255) NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `berita` (`id`,`judul`,`tanggal`,`ringkasan`,`isi`,`gambar`) VALUES
(29,'Kerja Bakti Bersihkan Embung Desa','17 Juli 2026','Warga Desa Maor bergotong royong membersihkan area embung untuk persiapan musim kemarau.','Isi berita lengkap di sini...','default.jpg'),
(30,'Penyaluran Bantuan Bibit Padi','15 Juli 2026','Pemerintah Desa Maor menyalurkan bantuan bibit padi unggul kepada kelompok tani.','Isi berita lengkap di sini...','default.jpg'),
(31,'Posyandu Balita Bulan Juli Berjalan Lancar','10 Juli 2026','Kegiatan posyandu rutin bulan ini dihadiri oleh puluhan balita dan ibu hamil di Polindes.','Isi berita lengkap di sini...','default.jpg'),
(33,'Kerja Bakti','25 July 2026','Kerja bakti rt 3 rw1','kerjabakti rt 3 josjis','Cuplikan_layar_2026-07-23_232556.png'),
(34,'Sosialisasi','27 July 2026','Sosialisasi pupuk','Sosialisasi pupuk POC','berita_20260727153224143879_1.monitoring_model_accuracy_value.png'),
(35,'Sosialisasi','27 July 2026','Sosialisasi TTG','-','berita_20260727154828909147_Asah_2025_-_Sesi_Capstone_Briefing_1.png');

DROP TABLE IF EXISTS `poi`;
CREATE TABLE `poi` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `nama` VARCHAR(255) NOT NULL, `kategori` VARCHAR(255) NOT NULL, `deskripsi` TEXT NOT NULL, `lat` DOUBLE NOT NULL, `lng` DOUBLE NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `poi` (`id`,`nama`,`kategori`,`deskripsi`,`lat`,`lng`) VALUES
(1,'Kantor Kepala Desa Maor','Pemerintahan','Pusat pelayanan administrasi dan pemerintahan Desa Maor.',-7.204406966500724,112.35340342229905),
(2,'Masjid Desa'' Maor','Peribadatan','Masjid utama yang menjadi pusat kegiatan keagamaan warga setempat.',-7.205148801479981,112.35316240013985),
(3,'MI Maor','Pendidikan','Madrasah Ibtidaiyah yang melayani pendidikan dasar agama anak-anak.',-7.205347319005749,112.35317659401258),
(4,'SD Negeri Maor','Pendidikan','Sekolah dasar negeri yang memfasilitasi belajar mengajar usia dini di desa.',-7.204453077046238,112.35311269110177),
(5,'Embung Desa','Pengairan','Sumber penampungan air untuk irigasi persawahan, khususnya saat musim kemarau.',-7.208761992401299,112.3494784965776),
(6,'Polindes Desa Maor','Kesehatan','Fasilitas pondok bersalin dan layanan kesehatan dasar desa.',-7.204192253274142,112.35324059733296),
(7,'Tour And Travel Mujahidin','Usaha Warga','Biro perjalanan dan layanan transportasi milik warga desa.',-7.204244921639009,112.35318431873094);

DROP TABLE IF EXISTS `kunjungan`;
CREATE TABLE `kunjungan` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `tanggal` DATE NOT NULL, `jumlah` BIGINT UNSIGNED NOT NULL DEFAULT 0, PRIMARY KEY (`id`), UNIQUE KEY `kunjungan_tanggal_unique` (`tanggal`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `kunjungan` (`id`,`tanggal`,`jumlah`) VALUES
(1,'2026-07-21',35),
(36,'2026-07-22',23),
(59,'2026-07-23',29),
(88,'2026-07-24',1),
(89,'2026-07-25',16),
(105,'2026-07-26',6),
(111,'2026-07-27',95),
(206,'2026-07-28',25),
(231,'2026-07-29',45);

DROP TABLE IF EXISTS `agenda`;
CREATE TABLE `agenda` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `judul` VARCHAR(255) NOT NULL, `tanggal` DATE NOT NULL, `waktu` VARCHAR(255) NOT NULL, `lokasi` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `agenda` (`id`,`judul`,`tanggal`,`waktu`,`lokasi`) VALUES
(1,'posyandu','2026-07-30','08:00 - selesai','polindes');

DROP TABLE IF EXISTS `infografis`;
CREATE TABLE `infografis` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `judul` VARCHAR(255) NOT NULL, `gambar` VARCHAR(255) NULL, `tanggal` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `infografis` (`id`,`judul`,`gambar`,`tanggal`) VALUES
(2,'Kerja Bakti rt 3','20260725123352_1.bukti_serving.png','25 July 2026'),
(3,'posyandu','1.bukti_serving.png','27 July 2026');

DROP TABLE IF EXISTS `struktur_organisasi`;
CREATE TABLE `struktur_organisasi` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `nama` VARCHAR(255) NOT NULL, `jabatan` VARCHAR(255) NOT NULL, `foto` VARCHAR(255) NULL, `urutan` INT NOT NULL DEFAULT 0, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `struktur_organisasi` (`id`,`nama`,`jabatan`,`foto`,`urutan`) VALUES
(1,'Sidik','Kepala Desa','struktur_20260727150835153492_Cuplikan_layar_2026-07-27_145517.png',1),
(2,'Nama Sekdes','Sekretaris Desa','default.jpg',2),
(3,'Nama','Kaur Keuangan','default.jpg',3);

DROP TABLE IF EXISTS `umkm`;
CREATE TABLE `umkm` (`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, `nama_produk` VARCHAR(255) NOT NULL, `nama_usaha` VARCHAR(255) NOT NULL, `kategori` VARCHAR(255) NOT NULL, `harga` INT NOT NULL DEFAULT 0, `satuan` VARCHAR(255) NOT NULL DEFAULT '-', `deskripsi` TEXT NULL, `nomor_wa` VARCHAR(255) NOT NULL, `alamat` TEXT NOT NULL, `maps_url` TEXT NOT NULL, `gambar` VARCHAR(255) NULL, `status` VARCHAR(255) NOT NULL DEFAULT 'aktif', `tanggal` VARCHAR(255) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `umkm` (`id`,`nama_produk`,`nama_usaha`,`kategori`,`harga`,`satuan`,`deskripsi`,`nomor_wa`,`alamat`,`maps_url`,`gambar`,`status`,`tanggal`) VALUES
(1,'Keripik Singkong','Keripik lancar jaya','Makanan',10000,'bungkus','Keripik enak','6281234567890','Ds. Maor','https://maps.app.goo.gl/auHFz5YWzcFkQaqz8','umkm_20260726232525_Cuplikan_layar_2026-07-26_225257.png','aktif','26 July 2026'),
(3,'keripik pisang','kripik gedang','Makanan',7000,'bungkus','enak manis gurih','6281234567890','ds maor','https://maps.app.goo.gl/auHFz5YWzcFkQaqz8','umkm_20260727003643_1.bukti_serving.png','aktif','27 July 2026');

SET FOREIGN_KEY_CHECKS=1;
