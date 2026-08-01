<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatistikDesaSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            /*
             * Nonaktifkan data periode lain agar hanya satu
             * data statistik yang tampil di halaman publik.
             */
            DB::table('statistik_desa')->update([
                'is_active' => false,
            ]);

            /*
             * Tambahkan atau perbarui data utama
             * per 31 Desember 2018.
             */
            DB::table('statistik_desa')->updateOrInsert(
                [
                    'tanggal_data' => '2018-12-31',
                ],
                [
                    'judul' => 'Kondisi Demografis Desa Maor',

                    'deskripsi' => implode(' ', [
                        'Dilihat dari perkembangan selama enam tahun,',
                        'dimulai tahun 2013 sampai dengan 2018,',
                        'jumlah penduduk Desa Maor setiap tahunnya',
                        'mengalami peningkatan.',
                    ]),

                    'total_penduduk' => 1310,
                    'laki_laki' => 651,
                    'perempuan' => 659,
                    'jumlah_kk' => 365,
                    'jumlah_rumah_tangga' => 65,

                    'sumber_data' => 'Pemerintah Desa Maor',
                    'is_active' => true,

                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );

            $statistikId = DB::table('statistik_desa')
                ->where('tanggal_data', '2018-12-31')
                ->value('id');

            /*
             * Hapus rincian lama agar seeder dapat dijalankan
             * kembali tanpa menghasilkan data ganda.
             */
            DB::table('statistik_rincian')
                ->where('statistik_desa_id', $statistikId)
                ->delete();

            $agama = [
                ['Pemeluk agama Islam', 1309],
                ['Pemeluk agama Kristen', 1],
                ['Pemeluk agama Katolik', null],
                ['Pemeluk agama Hindu', null],
                ['Pemeluk agama Buddha', null],
                ['Penganut kepercayaan', null],
            ];

            $pekerjaan = [
                ['Belum/tidak bekerja', 95],
                ['Mengurus rumah tangga', 25],
                ['Pelajar/Mahasiswa', 250],
                ['Pensiunan', 4],
                ['Pegawai Negeri Sipil/PNS', 7],
                ['Anggota TNI', 5],
                ['Kepolisian RI/Polri', 4],
                ['Wiraswasta', 15],
                ['Petani/Pekebunan', 761],
                ['Peternak', null],
                ['Nelayan/Perikanan', null],
                ['Industri', null],
                ['Transportasi', null],
                ['Konstruksi', null],
                ['Karyawan Swasta', 5],
                ['Karyawan BUMN', null],
                ['Karyawan BUMD', null],
                ['Karyawan Honorer', null],
                ['Buruh Harian Lepas', null],
                ['Buruh Pabrik', 75],
                ['Buruh Nelayan/Perikanan', null],
                ['Buruh Peternakan', null],
                ['Pembantu Rumah Tangga', null],
                ['Tukang Cukur', 2],
                ['Tukang Listrik', 1],
                ['Tukang Batu', 15],
                ['Tukang Kayu', 3],
                ['Tukang Sol Sepatu', null],
                ['Tukang Las/Pande Besi', 2],
                ['Tukang Jahit', 2],
                ['Tukang Gigi', null],
                ['Penata Rias', null],
                ['Penata Busana', null],
                ['Penata Rambut', null],
                ['Mekanik', null],
                ['Seniman', null],
                ['Anggota DPRD', null],
                ['Guru', 15],
                ['Bidan', 1],
                ['Perawat', 3],
                ['Sopir', 6],
                ['Paranormal', 5],
                ['Pedagang', 1],
                ['Perangkat Desa', 8],
                ['Kepala Desa', 1],
            ];

            $pendidikan = [
                ['Belum/Tidak Sekolah', 95],
                ['Belum Tamat SD/Sederajat', 200],
                ['Tamat SD/Sederajat', 549],
                ['Tamat SMP/Sederajat', 250],
                ['Tamat SLTA/Sederajat', 201],
                ['Diploma I/II/III', null],
                ['Sarjana S1', 13],
                ['Strata I/Diploma IV', null],
                ['Strata II', 2],
                ['Strata III', 1],
            ];

            $rows = [];

            foreach ($agama as $index => [$nama, $jumlah]) {
                $rows[] = $this->makeRow(
                    $statistikId,
                    'agama',
                    $nama,
                    $jumlah,
                    $index + 1
                );
            }

            foreach ($pekerjaan as $index => [$nama, $jumlah]) {
                $rows[] = $this->makeRow(
                    $statistikId,
                    'pekerjaan',
                    $nama,
                    $jumlah,
                    $index + 1
                );
            }

            foreach ($pendidikan as $index => [$nama, $jumlah]) {
                $rows[] = $this->makeRow(
                    $statistikId,
                    'pendidikan',
                    $nama,
                    $jumlah,
                    $index + 1
                );
            }

            DB::table('statistik_rincian')->insert($rows);
        });
    }

    private function makeRow(
        int $statistikId,
        string $kategori,
        string $nama,
        ?int $jumlah,
        int $urutan
    ): array {
        return [
            'statistik_desa_id' => $statistikId,
            'kategori' => $kategori,
            'nama' => $nama,
            'jumlah' => $jumlah,
            'satuan' => 'orang',
            'keterangan' => null,
            'urutan' => $urutan,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}