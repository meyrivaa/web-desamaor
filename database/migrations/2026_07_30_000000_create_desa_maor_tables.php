<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void {
 Schema::create('berita',function(Blueprint $t){$t->id();$t->string('judul');$t->string('tanggal');$t->text('ringkasan');$t->longText('isi');$t->string('gambar')->nullable();});
 Schema::create('poi',function(Blueprint $t){$t->id();$t->string('nama');$t->string('kategori');$t->text('deskripsi');$t->double('lat');$t->double('lng');});
 Schema::create('kunjungan',function(Blueprint $t){$t->id();$t->date('tanggal')->unique();$t->unsignedBigInteger('jumlah')->default(0);});
 Schema::create('agenda',function(Blueprint $t){$t->id();$t->string('judul');$t->date('tanggal');$t->string('waktu');$t->string('lokasi');});
 Schema::create('infografis',function(Blueprint $t){$t->id();$t->string('judul');$t->string('gambar')->nullable();$t->string('tanggal');});
 Schema::create('struktur_organisasi',function(Blueprint $t){$t->id();$t->string('nama');$t->string('jabatan');$t->string('foto')->nullable();$t->integer('urutan')->default(0);});
 Schema::create('umkm',function(Blueprint $t){$t->id();$t->string('nama_produk');$t->string('nama_usaha');$t->string('kategori');$t->integer('harga')->default(0);$t->string('satuan')->default('-');$t->text('deskripsi')->nullable();$t->string('nomor_wa');$t->text('alamat');$t->text('maps_url');$t->string('gambar')->nullable();$t->string('status')->default('aktif');$t->string('tanggal');});
 } public function down():void {foreach(['umkm','struktur_organisasi','infografis','agenda','kunjungan','poi','berita'] as $t)Schema::dropIfExists($t);} };
