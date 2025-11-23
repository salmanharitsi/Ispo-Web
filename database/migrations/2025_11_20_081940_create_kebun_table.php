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
            $table->integer('tahun_tanam_pertama')->nullable();
            $table->string('kondisi_tanah')->nullable();
            $table->integer('umur_tanaman')->nullable();
            $table->integer('jumlah_pohon')->nullable();
            $table->json('polygon')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('status_ispo', ['belum', 'proses', 'sudah'])->default('belum');
            $table->enum('status_finalisasi', ['belum', 'final'])->default('belum');
            $table->text('catatan_pengecekan')->nullable();
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
