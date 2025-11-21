<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kuisioner', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('user_id');
            $table->string('kebun_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('kebun_id')->references('id')->on('kebun')->onDelete('cascade');

            /**
             * PRINSIP 1 - Kepatuhan Terhadap Peraturan 
             * (Legalitas + Tata Ruang) - 6 Pertanyaan
             */
            $table->boolean('p1_dokumen_kepemilikan_sah')->default(false);
            $table->boolean('p1_batas_lahan_jelas')->default(false);
            $table->boolean('p1_di_luar_kawasan_hutan')->default(false);
            $table->boolean('p1_memiliki_stdb')->default(false);
            $table->boolean('p1_tidak_dalam_sengketa')->default(false);
            $table->boolean('p1_tahu_aturan_pemerintah')->default(false);

            /**
             * PRINSIP 2 - Penerapan Usaha Perkebunan
             * (Budidaya, Bibit, Produksi) - 10 Pertanyaan
             */
            $table->boolean('p2_bibit_bersertifikat')->default(false);
            $table->boolean('p2_catatan_pemupukan')->default(false);
            $table->boolean('p2_pemupukan_sesuai_kebutuhan')->default(false);
            $table->boolean('p2_panen_rutin')->default(false);
            $table->boolean('p2_rawat_piringan_tpt')->default(false); // TPT = tanaman penutup tanah
            $table->boolean('p2_kendali_gulma_tanpa_bakar')->default(false);
            $table->boolean('p2_pengendalian_hama_sesuai_anjuran')->default(false);
            $table->boolean('p2_pestisida_sesuai_label')->default(false);
            $table->boolean('p2_catatan_produksi_tbs')->default(false);
            $table->boolean('p2_tahu_standar_mutu_tbs')->default(false);

            /**
             * PRINSIP 3 - Pengelolaan & Pemantauan Lingkungan
             * (AMDAL/SPPL) - 6 Pertanyaan
             */
            $table->boolean('p3_memiliki_sppl')->default(false);
            $table->boolean('p3_kelola_limbah_kebun_benar')->default(false);
            $table->boolean('p3_hindari_bakar_lahan')->default(false);
            $table->boolean('p3_jaga_sumber_air')->default(false);
            $table->boolean('p3_hindari_pestisida_terlarang')->default(false);
            $table->boolean('p3_area_konservasi_kecil')->default(false);

            /**
             * PRINSIP 4 - Peningkatan Usaha
             * (Kelembagaan, Pelatihan, Catatan Usaha) - 7 Pertanyaan
             */
            $table->boolean('p4_tergabung_kelompok_tani')->default(false);
            $table->boolean('p4_kelompok_aktif_pembinaan')->default(false);
            $table->boolean('p4_pelatihan_budidaya_sawit')->default(false);
            $table->boolean('p4_pelatihan_ispo')->default(false);
            $table->boolean('p4_tahu_manfaat_ispo')->default(false);
            $table->boolean('p4_catat_biaya_usaha')->default(false);
            $table->boolean('p4_catat_pendapatan_tbs')->default(false);

            /**
             * PRINSIP 5 - Peningkatan Kesejahteraan Pekebun
             * (Ekonomi & Keberlanjutan Usaha) - 4 Pertanyaan
             */
            $table->boolean('p5_pendapatan_cukup')->default(false);
            $table->boolean('p5_siap_sertifikasi_ispo')->default(false);
            $table->boolean('p5_kesulitan_biaya_pemeliharaan')->default(false);
            $table->boolean('p5_butuh_dukungan_pembiayaan')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuisioner');
    }
};
