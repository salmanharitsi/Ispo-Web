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
             */
            $table->boolean('p1_q1_surat_kepemilikan_sah')->default(false);
            $table->boolean('p1_q2_di_luar_kawasan_terlarang')->default(false);
            $table->boolean('p1_q3_dokumen_penyelesaian_sengketa')->default(false);
            $table->boolean('p1_q4_salinan_perjanjian_sengketa')->default(false);
            $table->boolean('p1_q5_memiliki_stdb')->default(false);
            $table->boolean('p1_q6_sedang_mengurus_stdb')->default(false);
            $table->boolean('p1_q7_memiliki_izin_lingkungan')->default(false);
            $table->boolean('p1_q8_catatan_pengelolaan_lingkungan')->default(false);

            /**
             * PRINSIP 2 - Penerapan Usaha Perkebunan
             */
            $table->boolean('p2_q9_tergabung_kelompok_tani')->default(false);
            $table->boolean('p2_q10_kelompok_memiliki_dokumen_resmi')->default(false);
            $table->boolean('p2_q11_rencana_kerja_tertulis')->default(false);
            $table->boolean('p2_q12_catatan_kegiatan_kebun')->default(false);
            $table->boolean('p2_q13_buka_lahan_tanpa_bakar')->default(false); // TPT = tanaman penutup tanah
            $table->boolean('p2_q14_bibit_dari_produsen_resmi')->default(false);
            $table->boolean('p2_q15_catatan_asal_bibit')->default(false);
            $table->boolean('p2_q16_tanam_sesuai_standar')->default(false);
            $table->boolean('p2_q17_catatan_pelaksanaan_tanam')->default(false);
            $table->boolean('p2_q18_panduan_lahan_gambut')->default(false);
            $table->boolean('p2_q19_pemeliharaan_rutin')->default(false);
            $table->boolean('p2_q20_catatan_pemupukan_pemeliharaan')->default(false);
            $table->boolean('p2_q21_pengendalian_hama_sesuai_pht')->default(false);
            $table->boolean('p2_q22_sarana_pengendalian_hama')->default(false);
            $table->boolean('p2_q23_panen_buah_matang')->default(false);
            $table->boolean('p2_q24_catatan_hasil_panen')->default(false);
            $table->boolean('p2_q25_tbs_segera_diangkut')->default(false);

            /**
             * PRINSIP 3 - Pengelolaan & Pemantauan Lingkungan
             */
            $table->boolean('p3_q26_upaya_mencegah_kebakaran')->default(false);
            $table->boolean('p3_q27_mengetahui_satwa_tumbuhan')->default(false);
            $table->boolean('p3_q28_mencatat_satwa_tumbuhan')->default(false);

            /**
             * PRINSIP 4 - Peningkatan Usaha
             */
            $table->boolean('p4_q29_mendapat_info_resmi_harga')->default(false);
            $table->boolean('p4_q30_catat_harga_dan_jumlah_tbs')->default(false);
            $table->boolean('p4_q31_prosedur_pemberian_informasi')->default(false);
            $table->boolean('p4_q32_pernah_menerima_info_resmi')->default(false);

            /**
             * PRINSIP 5 - Peningkatan Kesejahteraan Pekebun
             */
            $table->boolean('p5_q33_rencana_perbaikan_usaha')->default(false);

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
