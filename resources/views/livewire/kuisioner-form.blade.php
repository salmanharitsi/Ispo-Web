<div class="p-4 sm:p-6 space-y-6">
    <form wire:submit.prevent="save" class="space-y-8">
        {{-- PRINSIP 1 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-slate-50/40">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 1
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Kepatuhan Terhadap Peraturan (Legalitas & Tata Ruang)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Jawab “Ya” jika kondisi tersebut sudah sesuai di kebun Anda.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-scale-balanced text-[10px]"></i>
                    <span>6 Pertanyaan</span>
                </span>
            </div>

            <div class="space-y-4">
                {{-- 1.1 --}}
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah lahan kebun Anda sudah memiliki dokumen kepemilikan yang sah?',
                    'model' => 'p1_dokumen_kepemilikan_sah',
                ])

                {{-- 1.2 --}}
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah batas lahan sudah Anda ketahui dan jelas di lapangan?',
                    'model' => 'p1_batas_lahan_jelas',
                ])

                {{-- 1.3 --}}
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah kebun Anda berada di luar kawasan hutan sesuai tata ruang?',
                    'model' => 'p1_di_luar_kawasan_hutan',
                ])

                {{-- 1.4 --}}
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda sudah memiliki STDB (Surat Tanda Daftar Budidaya)?',
                    'model' => 'p1_memiliki_stdb',
                ])

                {{-- 1.5 --}}
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah lahan kebun Anda tidak sedang dalam sengketa?',
                    'model' => 'p1_tidak_dalam_sengketa',
                ])

                {{-- 1.6 --}}
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mengetahui aturan pemerintah terkait budidaya sawit?',
                    'model' => 'p1_tahu_aturan_pemerintah',
                ])
            </div>
        </section>

        {{-- PRINSIP 2 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 2
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Penerapan Usaha Perkebunan (Budidaya, Bibit, Produksi)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Mengukur praktek budidaya, pemupukan, hingga pencatatan produksi.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-seedling text-[10px]"></i>
                    <span>10 Pertanyaan</span>
                </span>
            </div>

            <div class="space-y-4">
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda menggunakan bibit sawit bersertifikat?',
                    'model' => 'p2_bibit_bersertifikat',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda memiliki catatan pemupukan?',
                    'model' => 'p2_catatan_pemupukan',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda melakukan pemupukan sesuai kebutuhan tanaman?',
                    'model' => 'p2_pemupukan_sesuai_kebutuhan',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda melakukan panen secara rutin (misal 10–14 hari)?',
                    'model' => 'p2_panen_rutin',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda membersihkan piringan dan memelihara tanaman penutup tanah?',
                    'model' => 'p2_rawat_piringan_tpt',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mengendalikan gulma tanpa membakar lahan?',
                    'model' => 'p2_kendali_gulma_tanpa_bakar',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda melakukan pengendalian hama dan penyakit sesuai anjuran?',
                    'model' => 'p2_pengendalian_hama_sesuai_anjuran',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda menyimpan dan menggunakan pestisida sesuai aturan label?',
                    'model' => 'p2_pestisida_sesuai_label',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda memiliki catatan jumlah produksi TBS?',
                    'model' => 'p2_catatan_produksi_tbs',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda tahu standar mutu TBS yang diterapkan pembeli/PKS?',
                    'model' => 'p2_tahu_standar_mutu_tbs',
                ])
            </div>
        </section>

        {{-- PRINSIP 3 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-slate-50/40">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 3
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Pengelolaan & Pemantauan Lingkungan (AMDAL/SPPL)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Menilai kepedulian terhadap lingkungan di sekitar kebun.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-leaf text-[10px]"></i>
                    <span>6 Pertanyaan</span>
                </span>
            </div>

            <div class="space-y-4">
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda memiliki SPPL atau dokumen pengelolaan lingkungan?',
                    'model' => 'p3_memiliki_sppl',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mengelola limbah padat kebun dengan benar?',
                    'model' => 'p3_kelola_limbah_kebun_benar',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda menghindari penggunaan api untuk membuka lahan?',
                    'model' => 'p3_hindari_bakar_lahan',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda menjaga sungai, parit, atau sumber air di sekitar kebun?',
                    'model' => 'p3_jaga_sumber_air',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda menghindari penggunaan pestisida yang dilarang?',
                    'model' => 'p3_hindari_pestisida_terlarang',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda menanam tanaman pelindung atau menjaga area konservasi kecil di kebun?',
                    'model' => 'p3_area_konservasi_kecil',
                ])
            </div>
        </section>

        {{-- PRINSIP 4 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 4
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Peningkatan Usaha (Kelembagaan, Pelatihan, Catatan Usaha)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Mengukur dukungan kelembagaan dan kemampuan pencatatan usaha pekebun.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-people-group text-[10px]"></i>
                    <span>7 Pertanyaan</span>
                </span>
            </div>

            <div class="space-y-4">
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda tergabung dalam kelompok tani atau koperasi?',
                    'model' => 'p4_tergabung_kelompok_tani',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah kelompok tani Anda aktif melakukan pertemuan atau pembinaan?',
                    'model' => 'p4_kelompok_aktif_pembinaan',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda pernah mengikuti pelatihan budidaya sawit?',
                    'model' => 'p4_pelatihan_budidaya_sawit',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda pernah mengikuti pelatihan terkait ISPO?',
                    'model' => 'p4_pelatihan_ispo',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mengetahui manfaat sertifikasi ISPO?',
                    'model' => 'p4_tahu_manfaat_ispo',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mencatat biaya usaha (pupuk, panen, operasional)?',
                    'model' => 'p4_catat_biaya_usaha',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mencatat pendapatan dari hasil penjualan TBS?',
                    'model' => 'p4_catat_pendapatan_tbs',
                ])
            </div>
        </section>

        {{-- PRINSIP 5 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-slate-50/40">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 5
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Peningkatan Kesejahteraan Pekebun (Ekonomi & Keberlanjutan Usaha)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Menilai keberlanjutan ekonomi pekebun dan kesiapan menuju sertifikasi.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-sack-dollar text-[10px]"></i>
                    <span>4 Pertanyaan</span>
                </span>
            </div>

            <div class="space-y-4">
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah pendapatan dari kebun cukup untuk memenuhi kebutuhan keluarga?',
                    'model' => 'p5_pendapatan_cukup',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda siap mengikuti sertifikasi ISPO jika biayanya terjangkau atau disubsidi?',
                    'model' => 'p5_siap_sertifikasi_ispo',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda mengalami kesulitan biaya dalam pemeliharaan kebun?',
                    'model' => 'p5_kesulitan_biaya_pemeliharaan',
                ])
                @include('pekebun.partials.kuisioner-question', [
                    'label' => 'Apakah Anda membutuhkan dukungan pembiayaan untuk meningkatkan produksi kebun?',
                    'model' => 'p5_butuh_dukungan_pembiayaan',
                ])
            </div>
        </section>

        {{-- Footer Form --}}
        <div class="border-t border-slate-100 pt-4 mt-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <p class="text-xs text-slate-500">
                * Jawab seluruh pertanyaan sesuai kondisi sebenarnya. Data ini akan digunakan sebagai dasar
                penilaian kesiapan sertifikasi ISPO.
            </p>
            <button 
                type="submit" 
                class="px-8 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition shadow-lg flex items-center justify-center cursor-pointer"
                wire:loading.attr="disabled"
                wire:target="save"
            >
                <span wire:loading.remove wire:target="save">
                <i class="fas fa-file mr-2"></i>
                Simpan Kuisioner
                </span>
                <span wire:loading wire:target="save" class="flex items-center">
                Menyimpan...
                </span>
            </button>
        </div>
    </form>
</div>
