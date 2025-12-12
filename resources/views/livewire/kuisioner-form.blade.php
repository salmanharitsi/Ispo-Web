<div class="p-4 sm:p-6 space-y-6">
    <form wire:submit.prevent="save" class="space-y-8">
        
        {{-- PRINSIP 1 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-slate-50/40">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 1
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Kepatuhan terhadap Peraturan & Legalitas
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Jawab "Ya" jika kondisi tersebut sudah sesuai di kebun Anda.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-scale-balanced text-[10px]"></i>
                    <span>8 Pertanyaan</span>
                </span>
            </div>

            {{-- Kriteria 1.1 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        1.1
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Legalitas lahan</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda memiliki surat kepemilikan lahan yang sah (sertifikat, akta jual beli, girik, atau dokumen kepemilikan lain)?',
                        'model' => 'p1_q1_surat_kepemilikan_sah',
                    ])
                </div>
            </div>

            {{-- Kriteria 1.2 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        1.2
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Lokasi kebun sesuai aturan</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah kebun Anda berada di luar kawasan hutan atau area yang dilarang tanam?',
                        'model' => 'p1_q2_di_luar_kawasan_terlarang',
                    ])
                </div>
            </div>

            {{-- Kriteria 1.3 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        1.3
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Sengketa lahan & penyelesaian</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Jika lahan Anda pernah disengketakan, apakah ada dokumen hasil musyawarah penyelesaian sengketa?',
                        'model' => 'p1_q3_dokumen_penyelesaian_sengketa',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Jika telah ada kesepakatan penyelesaian sengketa, apakah Anda memiliki salinan perjanjian tertulisnya?',
                        'model' => 'p1_q4_salinan_perjanjian_sengketa',
                    ])
                </div>
            </div>

            {{-- Kriteria 1.4 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        1.4
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Legalitas usaha perkebunan</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda sudah memiliki STDB (Surat Tanda Daftar Budidaya)?',
                        'model' => 'p1_q5_memiliki_stdb',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda sedang mengurus STDB (Surat Tanda Daftar Budidaya)?',
                        'model' => 'p1_q6_sedang_mengurus_stdb',
                    ])
                </div>
            </div>

            {{-- Kriteria 1.5 --}}
            <div>
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        1.5
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Izin lingkungan & kepatuhan lingkungan</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda memiliki izin lingkungan sesuai regulasi SPPL (atau dokumen izin lingkungan lain)?',
                        'model' => 'p1_q7_memiliki_izin_lingkungan',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda memiliki catatan bahwa Anda telah menjalankan pengelolaan lingkungan sesuai izin tersebut (misalnya limbah, saluran air, pembatasan pembakaran)?',
                        'model' => 'p1_q8_catatan_pengelolaan_lingkungan',
                    ])
                </div>
            </div>
        </section>

        {{-- PRINSIP 2 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 2
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Praktik Budidaya yang Baik (Good Agricultural Practices & Manajemen Kebun)
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Mengukur praktik budidaya, manajemen, dan produksi kebun sawit.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-seedling text-[10px]"></i>
                    <span>17 Pertanyaan</span>
                </span>
            </div>

            {{-- Kriteria 2.1 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        2.1
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Kelembagaan pekebun</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda tergabung dalam kelompok tani atau koperasi pekebun?',
                        'model' => 'p2_q9_tergabung_kelompok_tani',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah kelompok tani atau koperasi tersebut memiliki dokumen resmi (pembentukan, daftar anggota, atau pengesahan)?',
                        'model' => 'p2_q10_kelompok_memiliki_dokumen_resmi',
                    ])
                </div>
            </div>

            {{-- Kriteria 2.2 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        2.2
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Manajemen usaha / kelompok</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda atau kelompok tani memiliki rencana kerja tertulis (rencana usaha kebun)?',
                        'model' => 'p2_q11_rencana_kerja_tertulis',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda atau kelompok tani memiliki laporan kegiatan kebun atau catatan kegiatan rutin?',
                        'model' => 'p2_q12_catatan_kegiatan_kebun',
                    ])
                </div>
            </div>

            {{-- Kriteria 2.3 --}}
            <div>
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        2.3
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Teknis budidaya & produksi</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Saat membuka lahan baru, apakah Anda melakukannya tanpa membakar?',
                        'model' => 'p2_q13_buka_lahan_tanpa_bakar',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah bibit sawit yang Anda gunakan berasal dari produsen resmi/bersertifikat?',
                        'model' => 'p2_q14_bibit_dari_produsen_resmi',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda mempunyai catatan asal bibit (asal benih, tanggal perolehan)?',
                        'model' => 'p2_q15_catatan_asal_bibit',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda menanam dengan jarak tanam dan cara yang sesuai standar tanam sawit?',
                        'model' => 'p2_q16_tanam_sesuai_standar',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda mencatat pelaksanaan penanaman (tanggal tanam, jumlah bibit, luas lahan)?',
                        'model' => 'p2_q17_catatan_pelaksanaan_tanam',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Jika kebun Anda berada di lahan gambut: apakah Anda mengikuti panduan teknis khusus penanaman di lahan gambut (sesuai aturan)?',
                        'model' => 'p2_q18_panduan_lahan_gambut',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda melakukan pemeliharaan tanaman secara rutin (pemupukan, pemangkasan pelepah, perawatan saluran air, dsb)?',
                        'model' => 'p2_q19_pemeliharaan_rutin',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda menyimpan catatan pemupukan dan kegiatan pemeliharaan tanaman?',
                        'model' => 'p2_q20_catatan_pemupukan_pemeliharaan',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda menerapkan pengendalian hama secara terencana sesuai pedoman PHT (misalnya rotasi, pestisida aman, pengamatan rutin)?',
                        'model' => 'p2_q21_pengendalian_hama_sesuai_pht',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda memiliki alat atau sarana untuk pengendalian hama sesuai pedoman (semprot, pelindung, perangkap, dsb)?',
                        'model' => 'p2_q22_sarana_pengendalian_hama',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda memanen buah hanya ketika buah sudah matang panen?',
                        'model' => 'p2_q23_panen_buah_matang',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda mencatat hasil panen (jumlah tandan, tanggal panen)?',
                        'model' => 'p2_q24_catatan_hasil_panen',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Setelah panen, apakah TBS segera diangkut ke pembeli/pabrik tanpa penundaan yang lama?',
                        'model' => 'p2_q25_tbs_segera_diangkut',
                    ])
                </div>
            </div>
        </section>

        {{-- PRINSIP 3 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-slate-50/40">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 3
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Lingkungan & Keanekaragaman Hayati
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Menilai kepedulian terhadap lingkungan dan pelestarian keanekaragaman hayati.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-leaf text-[10px]"></i>
                    <span>3 Pertanyaan</span>
                </span>
            </div>

            {{-- Kriteria 3.1 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        3.1
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Pencegahan & penanggulangan kebakaran</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda ikut serta atau melaksanakan upaya mencegah kebakaran kebun (misalnya membuat sekat api, patroli, gotong royong dengan warga)?',
                        'model' => 'p3_q26_upaya_mencegah_kebakaran',
                    ])
                </div>
            </div>

            {{-- Kriteria 3.2 --}}
            <div>
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        3.2
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Pelestarian Keanekaragaman Hayati</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda mengetahui adanya satwa atau tumbuhan liar di atau dekat kebun sebelum atau sesudah kebun dibuat?',
                        'model' => 'p3_q27_mengetahui_satwa_tumbuhan',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda pernah mencatat atau mendokumentasikan keberadaan satwa/tumbuhan tersebut?',
                        'model' => 'p3_q28_mencatat_satwa_tumbuhan',
                    ])
                </div>
            </div>
        </section>

        {{-- PRINSIP 4 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-white">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 4
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Transparansi dalam Penjualan & Informasi
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Mengukur transparansi harga, penjualan, dan penyediaan informasi usaha.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-chart-line text-[10px]"></i>
                    <span>4 Pertanyaan</span>
                </span>
            </div>

            {{-- Kriteria 4.1 --}}
            <div class="mb-5">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        4.1
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Harga & penjualan TBS</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda mendapatkan informasi resmi harga TBS dari tim penetapan harga sebelum menjual?',
                        'model' => 'p4_q29_mendapat_info_resmi_harga',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda mencatat harga dan jumlah TBS yang Anda jual?',
                        'model' => 'p4_q30_catat_harga_dan_jumlah_tbs',
                    ])
                </div>
            </div>

            {{-- Kriteria 4.2 --}}
            <div>
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        4.2
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Penyediaan data & informasi usaha</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah kelompok tani/koperasi Anda memiliki prosedur atau aturan tertulis untuk memberikan informasi kepada anggota/petani?',
                        'model' => 'p4_q31_prosedur_pemberian_informasi',
                    ])
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda pernah menerima informasi resmi tentang kebun/aturan/standar dari kelompok tani, koperasi, atau instansi terkait?',
                        'model' => 'p4_q32_pernah_menerima_info_resmi',
                    ])
                </div>
            </div>
        </section>

        {{-- PRINSIP 5 --}}
        <section class="border border-slate-100 rounded-2xl p-4 sm:p-5 shadow-sm bg-slate-50/40">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-600 mb-1">
                        Prinsip 5
                    </p>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-900">
                        Peningkatan Usaha & Keberlanjutan Kebun
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Menilai rencana perbaikan dan keberlanjutan usaha kebun jangka panjang.
                    </p>
                </div>
                <span class="inline-flex items-center gap-1 rounded-full bg-white px-3 py-1 text-[11px] font-medium text-slate-500 border border-slate-200 w-fit">
                    <i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                    <span>1 Pertanyaan</span>
                </span>
            </div>

            {{-- Kriteria 5.1 --}}
            <div>
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-200">
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold">
                        5.1
                    </span>
                    <h3 class="text-xs font-semibold text-slate-700">Perbaikan usaha secara berkelanjutan</h3>
                </div>
                <div class="space-y-4">
                    @include('pekebun.partials.kuisioner-question', [
                        'label' => 'Apakah Anda memiliki rencana atau sudah melakukan upaya perbaikan kebun (misalnya perbaikan drainase, re-planting, perbaikan perawatan, perbaikan manajemen) untuk jangka panjang?',
                        'model' => 'p5_q33_rencana_perbaikan_usaha',
                    ])
                </div>
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