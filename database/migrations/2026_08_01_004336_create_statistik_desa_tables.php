<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        /*
         * Menyimpan ringkasan utama statistik Desa Maor.
         * Setiap periode dapat memiliki satu data ringkasan.
         */
        Schema::create('statistik_desa', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal_data');

            $table->string('judul')
                ->default('Kondisi Demografis Desa Maor');

            $table->text('deskripsi')->nullable();

            $table->unsignedInteger('total_penduduk');
            $table->unsignedInteger('laki_laki');
            $table->unsignedInteger('perempuan');
            $table->unsignedInteger('jumlah_kk');
            $table->unsignedInteger('jumlah_rumah_tangga');

            $table->string('sumber_data')->nullable();

            /*
             * Menentukan data periode yang sedang ditampilkan
             * pada halaman publik.
             */
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        /*
         * Menyimpan rincian statistik berdasarkan kategori:
         * agama, pekerjaan, dan pendidikan.
         */
        Schema::create('statistik_rincian', function (Blueprint $table) {
            $table->id();

            $table->foreignId('statistik_desa_id')
                ->constrained('statistik_desa')
                ->cascadeOnDelete();

            $table->string('kategori', 30);
            $table->string('nama');

            /*
             * Dibuat nullable agar tanda "-" atau data yang
             * belum tersedia tidak dipaksa menjadi angka nol.
             */
            $table->unsignedInteger('jumlah')->nullable();

            $table->string('satuan', 30)->default('orang');
            $table->string('keterangan')->nullable();
            $table->unsignedInteger('urutan')->default(0);

            $table->timestamps();

            $table->index([
                'statistik_desa_id',
                'kategori',
                'urutan',
            ]);
        });
    }

    public function down(): void
    {
        /*
         * Tabel rincian dihapus lebih dahulu karena memiliki
         * hubungan foreign key ke tabel statistik_desa.
         */
        Schema::dropIfExists('statistik_rincian');
        Schema::dropIfExists('statistik_desa');
    }
};