<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kebun', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_kebun');
            $table->string('lokasi_kebun');
            $table->decimal('luas_lahan', 8, 2);
            $table->string('desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->integer('tahun_tanam')->nullable();
            $table->integer('jumlah_pohon')->nullable();
            $table->enum('status_ispo', ['belum', 'proses', 'sudah'])->default('belum');
            $table->enum('status_finalisasi', ['belum', 'final'])->default('belum');
            $table->text('catatan_pengecekan')->nullable();

            $table->json('polygon')->nullable();
            $table->json('polygon_sides')->nullable();
            $table->json('centroid')->nullable();
            $table->decimal('area_m2', 12, 2)->nullable();
            $table->decimal('area_hectare', 10, 4)->nullable();
            $table->decimal('perimeter_m', 10, 2)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->string('jenis_tanah')->nullable(); 
            $table->string('asal_lahan')->nullable(); 
            $table->string('status_lahan')->nullable(); 
            $table->string('dokumen_kepemilikan_lahan')->nullable(); 
            $table->string('jenis_bibit')->nullable(); 
            $table->integer('frekuensi_panen')->nullable(); 
            $table->string('kepada_siapa_hasil_panen_dijual')->nullable(); 
            $table->integer('harga_jual_tbs_terakhir')->nullable(); 
            $table->integer('pendapatan_bersih')->nullable(); 
            $table->boolean('pernyataan_stdb')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebun');
    }
};
