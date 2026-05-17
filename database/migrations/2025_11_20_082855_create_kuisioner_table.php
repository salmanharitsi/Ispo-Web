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
             * PRINSIP 1 - Kepatuhan Terhadap Peraturan & Legalitas
             */
            $table->decimal('p1_q1_surat_kepemilikan_sah', 8, 4)->default(0);
            $table->decimal('p1_q2_di_luar_kawasan_terlarang', 8, 4)->default(0);
            $table->decimal('p1_q3_dokumen_penyelesaian_sengketa', 8, 4)->default(0);
            $table->decimal('p1_q4_salinan_perjanjian_sengketa', 8, 4)->default(0);
            $table->decimal('p1_q5_memiliki_stdb', 8, 4)->default(0);
            $table->decimal('p1_q6_memiliki_izin_lingkungan', 8, 4)->default(0);
            $table->decimal('p1_q7_catatan_pengelolaan_lingkungan', 8, 4)->default(0);

            /**
             * PRINSIP 2 - Praktik Budidaya & Manajemen Kebun
             */
            $table->decimal('p2_q8_tergabung_kelompok_tani', 8, 4)->default(0);
            $table->decimal('p2_q9_kelompok_memiliki_dokumen_resmi', 8, 4)->default(0);
            $table->decimal('p2_q10_rencana_kerja_tertulis', 8, 4)->default(0);
            $table->decimal('p2_q11_catatan_kegiatan_kebun', 8, 4)->default(0);
            $table->decimal('p2_q12_buka_lahan_tanpa_bakar', 8, 4)->default(0);
            $table->decimal('p2_q13_bibit_dari_produsen_resmi', 8, 4)->default(0);
            $table->decimal('p2_q14_catatan_asal_bibit', 8, 4)->default(0);
            $table->decimal('p2_q15_tanam_sesuai_standar', 8, 4)->default(0);
            $table->decimal('p2_q16_catatan_pelaksanaan_tanam', 8, 4)->default(0);
            $table->decimal('p2_q17_panduan_lahan_gambut', 8, 4)->default(0);
            $table->decimal('p2_q18_pemeliharaan_rutin', 8, 4)->default(0);
            $table->decimal('p2_q19_catatan_pemupukan_pemeliharaan', 8, 4)->default(0);
            $table->decimal('p2_q20_pengendalian_hama_sesuai_pht', 8, 4)->default(0);
            $table->decimal('p2_q21_sarana_pengendalian_hama', 8, 4)->default(0);
            $table->decimal('p2_q22_panen_buah_matang', 8, 4)->default(0);
            $table->decimal('p2_q23_catatan_hasil_panen', 8, 4)->default(0);
            $table->decimal('p2_q24_tbs_segera_diangkut', 8, 4)->default(0);

            /**
             * PRINSIP 3 - Lingkungan & Keanekaragaman Hayati
             */
            $table->decimal('p3_q25_upaya_mencegah_kebakaran', 8, 4)->default(0);
            $table->decimal('p3_q26_memiliki_alat_pemadam', 8, 4)->default(0);
            $table->decimal('p3_q27_mengetahui_satwa_tumbuhan', 8, 4)->default(0);
            $table->decimal('p3_q28_mencatat_satwa_tumbuhan', 8, 4)->default(0);

            /**
             * PRINSIP 4 - Transparansi dalam Penjualan & Informasi
             */
            $table->decimal('p4_q29_mendapat_info_resmi_harga', 8, 4)->default(0);
            $table->decimal('p4_q30_catat_harga_dan_jumlah_tbs', 8, 4)->default(0);
            $table->decimal('p4_q31_prosedur_pemberian_informasi', 8, 4)->default(0);
            $table->decimal('p4_q32_pernah_menerima_info_resmi', 8, 4)->default(0);

            /**
             * PRINSIP 5 - Peningkatan Usaha & Keberlanjutan Kebun
             */
            $table->decimal('p5_q33_rencana_perbaikan_usaha', 8, 4)->default(0);

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
