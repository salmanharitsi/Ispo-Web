<?php

namespace App\Livewire;

use App\Models\Kebun;
use App\Models\Kuisioner;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class KuisionerForm extends Component
{
    public string $kebunId;
    public Kebun $kebun;
    public ?Kuisioner $kuisioner = null;

    // PRINSIP 1
    public ?string $p1_q1_surat_kepemilikan_sah = null;
    public ?string $p1_q2_di_luar_kawasan_terlarang = null;
    public ?string $p1_q3_dokumen_penyelesaian_sengketa = null;
    public ?string $p1_q4_salinan_perjanjian_sengketa = null;
    public ?string $p1_q5_memiliki_stdb = null;
    public ?string $p1_q6_sedang_mengurus_stdb = null;
    public ?string $p1_q7_memiliki_izin_lingkungan = null;
    public ?string $p1_q8_catatan_pengelolaan_lingkungan = null;

    // PRINSIP 2
    public ?string $p2_q9_tergabung_kelompok_tani = null;
    public ?string $p2_q10_kelompok_memiliki_dokumen_resmi = null;
    public ?string $p2_q11_rencana_kerja_tertulis = null;
    public ?string $p2_q12_catatan_kegiatan_kebun = null;
    public ?string $p2_q13_buka_lahan_tanpa_bakar = null;
    public ?string $p2_q14_bibit_dari_produsen_resmi = null;
    public ?string $p2_q15_catatan_asal_bibit = null;
    public ?string $p2_q16_tanam_sesuai_standar = null;
    public ?string $p2_q17_catatan_pelaksanaan_tanam = null;
    public ?string $p2_q18_panduan_lahan_gambut = null;
    public ?string $p2_q19_pemeliharaan_rutin = null;
    public ?string $p2_q20_catatan_pemupukan_pemeliharaan = null;
    public ?string $p2_q21_pengendalian_hama_sesuai_pht = null;
    public ?string $p2_q22_sarana_pengendalian_hama = null;
    public ?string $p2_q23_panen_buah_matang = null;
    public ?string $p2_q24_catatan_hasil_panen = null;
    public ?string $p2_q25_tbs_segera_diangkut = null;

    // PRINSIP 3
    public ?string $p3_q26_upaya_mencegah_kebakaran = null;
    public ?string $p3_q27_mengetahui_satwa_tumbuhan = null;
    public ?string $p3_q28_mencatat_satwa_tumbuhan = null;

    // PRINSIP 4
    public ?string $p4_q29_mendapat_info_resmi_harga = null;
    public ?string $p4_q30_catat_harga_dan_jumlah_tbs = null;
    public ?string $p4_q31_prosedur_pemberian_informasi = null;
    public ?string $p4_q32_pernah_menerima_info_resmi = null;

    // PRINSIP 5
    public ?string $p5_q33_rencana_perbaikan_usaha = null;

    protected function rules(): array
    {
        $bool = 'required|in:0,1';

        return [
            // P1
            'p1_q1_surat_kepemilikan_sah' => $bool,
            'p1_q2_di_luar_kawasan_terlarang' => $bool,
            'p1_q3_dokumen_penyelesaian_sengketa' => $bool,
            'p1_q4_salinan_perjanjian_sengketa' => $bool,
            'p1_q5_memiliki_stdb' => $bool,
            'p1_q6_sedang_mengurus_stdb' => $bool,
            'p1_q7_memiliki_izin_lingkungan' => $bool,
            'p1_q8_catatan_pengelolaan_lingkungan' => $bool,

            // P2
            'p2_q9_tergabung_kelompok_tani' => $bool,
            'p2_q10_kelompok_memiliki_dokumen_resmi' => $bool,
            'p2_q11_rencana_kerja_tertulis' => $bool,
            'p2_q12_catatan_kegiatan_kebun' => $bool,
            'p2_q13_buka_lahan_tanpa_bakar' => $bool,
            'p2_q14_bibit_dari_produsen_resmi' => $bool,
            'p2_q15_catatan_asal_bibit' => $bool,
            'p2_q16_tanam_sesuai_standar' => $bool,
            'p2_q17_catatan_pelaksanaan_tanam' => $bool,
            'p2_q18_panduan_lahan_gambut' => $bool,
            'p2_q19_pemeliharaan_rutin' => $bool,
            'p2_q20_catatan_pemupukan_pemeliharaan' => $bool,
            'p2_q21_pengendalian_hama_sesuai_pht' => $bool,
            'p2_q22_sarana_pengendalian_hama' => $bool,
            'p2_q23_panen_buah_matang' => $bool,
            'p2_q24_catatan_hasil_panen' => $bool,
            'p2_q25_tbs_segera_diangkut' => $bool,

            // P3
            'p3_q26_upaya_mencegah_kebakaran' => $bool,
            'p3_q27_mengetahui_satwa_tumbuhan' => $bool,
            'p3_q28_mencatat_satwa_tumbuhan' => $bool,

            // P4
            'p4_q29_mendapat_info_resmi_harga' => $bool,
            'p4_q30_catat_harga_dan_jumlah_tbs' => $bool,
            'p4_q31_prosedur_pemberian_informasi' => $bool,
            'p4_q32_pernah_menerima_info_resmi' => $bool,

            // P5
            'p5_q33_rencana_perbaikan_usaha' => $bool,
        ];
    }

    public function mount(string $kebunId): void
    {
        $this->kebunId = $kebunId;

        $this->kebun = Kebun::with('kuisioner')
            ->where('id', $kebunId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $this->kuisioner = $this->kebun->kuisioner;

        if ($this->kuisioner) {
            $this->fillFromModel();
        }
    }

    protected function fillFromModel(): void
    {
        $k = $this->kuisioner;

        // helper: true → '1', false → '0'
        $b = fn ($val) => $val ? '1' : '0';

        // P1
        $this->p1_q1_surat_kepemilikan_sah = $b($k->p1_q1_surat_kepemilikan_sah);
        $this->p1_q2_di_luar_kawasan_terlarang = $b($k->p1_q2_di_luar_kawasan_terlarang);
        $this->p1_q3_dokumen_penyelesaian_sengketa = $b($k->p1_q3_dokumen_penyelesaian_sengketa);
        $this->p1_q4_salinan_perjanjian_sengketa = $b($k->p1_q4_salinan_perjanjian_sengketa);
        $this->p1_q5_memiliki_stdb = $b($k->p1_q5_memiliki_stdb);
        $this->p1_q6_sedang_mengurus_stdb = $b($k->p1_q6_sedang_mengurus_stdb);
        $this->p1_q7_memiliki_izin_lingkungan = $b($k->p1_q7_memiliki_izin_lingkungan);
        $this->p1_q8_catatan_pengelolaan_lingkungan = $b($k->p1_q8_catatan_pengelolaan_lingkungan);

        // P2
        $this->p2_q9_tergabung_kelompok_tani = $b($k->p2_q9_tergabung_kelompok_tani);
        $this->p2_q10_kelompok_memiliki_dokumen_resmi = $b($k->p2_q10_kelompok_memiliki_dokumen_resmi);
        $this->p2_q11_rencana_kerja_tertulis = $b($k->p2_q11_rencana_kerja_tertulis);
        $this->p2_q12_catatan_kegiatan_kebun = $b($k->p2_q12_catatan_kegiatan_kebun);
        $this->p2_q13_buka_lahan_tanpa_bakar = $b($k->p2_q13_buka_lahan_tanpa_bakar);
        $this->p2_q14_bibit_dari_produsen_resmi = $b($k->p2_q14_bibit_dari_produsen_resmi);
        $this->p2_q15_catatan_asal_bibit = $b($k->p2_q15_catatan_asal_bibit);
        $this->p2_q16_tanam_sesuai_standar = $b($k->p2_q16_tanam_sesuai_standar);
        $this->p2_q17_catatan_pelaksanaan_tanam = $b($k->p2_q17_catatan_pelaksanaan_tanam);
        $this->p2_q18_panduan_lahan_gambut = $b($k->p2_q18_panduan_lahan_gambut);
        $this->p2_q19_pemeliharaan_rutin = $b($k->p2_q19_pemeliharaan_rutin);
        $this->p2_q20_catatan_pemupukan_pemeliharaan = $b($k->p2_q20_catatan_pemupukan_pemeliharaan);
        $this->p2_q21_pengendalian_hama_sesuai_pht = $b($k->p2_q21_pengendalian_hama_sesuai_pht);
        $this->p2_q22_sarana_pengendalian_hama = $b($k->p2_q22_sarana_pengendalian_hama);  
        $this->p2_q23_panen_buah_matang = $b($k->p2_q23_panen_buah_matang);
        $this->p2_q24_catatan_hasil_panen = $b($k->p2_q24_catatan_hasil_panen);
        $this->p2_q25_tbs_segera_diangkut = $b($k->p2_q25_tbs_segera_diangkut);

        // P3
        $this->p3_q26_upaya_mencegah_kebakaran = $b($k->p3_q26_upaya_mencegah_kebakaran);
        $this->p3_q27_mengetahui_satwa_tumbuhan = $b($k->p3_q27_mengetahui_satwa_tumbuhan);
        $this->p3_q28_mencatat_satwa_tumbuhan = $b($k->p3_q28_mencatat_satwa_tumbuhan);

        // P4
        $this->p4_q29_mendapat_info_resmi_harga = $b($k->p4_q29_mendapat_info_resmi_harga);
        $this->p4_q30_catat_harga_dan_jumlah_tbs = $b($k->p4_q30_catat_harga_dan_jumlah_tbs);
        $this->p4_q31_prosedur_pemberian_informasi = $b($k->p4_q31_prosedur_pemberian_informasi);
        $this->p4_q32_pernah_menerima_info_resmi = $b($k->p4_q32_pernah_menerima_info_resmi);

        // P5
        $this->p5_q33_rencana_perbaikan_usaha = $b($k->p5_q33_rencana_perbaikan_usaha);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'kebun_id' => $this->kebun->id,

            // P1
            'p1_q1_surat_kepemilikan_sah' => $this->p1_q1_surat_kepemilikan_sah === '1',
            'p1_q2_di_luar_kawasan_terlarang' => $this->p1_q2_di_luar_kawasan_terlarang === '1',
            'p1_q3_dokumen_penyelesaian_sengketa' => $this->p1_q3_dokumen_penyelesaian_sengketa === '1',
            'p1_q4_salinan_perjanjian_sengketa' => $this->p1_q4_salinan_perjanjian_sengketa === '1',
            'p1_q5_memiliki_stdb' => $this->p1_q5_memiliki_stdb === '1',
            'p1_q6_sedang_mengurus_stdb' => $this->p1_q6_sedang_mengurus_stdb === '1',
            'p1_q7_memiliki_izin_lingkungan' => $this->p1_q7_memiliki_izin_lingkungan === '1',
            'p1_q8_catatan_pengelolaan_lingkungan' => $this->p1_q8_catatan_pengelolaan_lingkungan === '1',

            // P2
            'p2_q9_tergabung_kelompok_tani' => $this->p2_q9_tergabung_kelompok_tani === '1',
            'p2_q10_kelompok_memiliki_dokumen_resmi' => $this->p2_q10_kelompok_memiliki_dokumen_resmi === '1',
            'p2_q11_rencana_kerja_tertulis' => $this->p2_q11_rencana_kerja_tertulis === '1',
            'p2_q12_catatan_kegiatan_kebun' => $this->p2_q12_catatan_kegiatan_kebun === '1',
            'p2_q13_buka_lahan_tanpa_bakar' => $this->p2_q13_buka_lahan_tanpa_bakar === '1',
            'p2_q14_bibit_dari_produsen_resmi' => $this->p2_q14_bibit_dari_produsen_resmi === '1',
            'p2_q15_catatan_asal_bibit' => $this->p2_q15_catatan_asal_bibit === '1',
            'p2_q16_tanam_sesuai_standar' => $this->p2_q16_tanam_sesuai_standar === '1',
            'p2_q17_catatan_pelaksanaan_tanam' => $this->p2_q17_catatan_pelaksanaan_tanam === '1',
            'p2_q18_panduan_lahan_gambut' => $this->p2_q18_panduan_lahan_gambut === '1',
            'p2_q19_pemeliharaan_rutin' => $this->p2_q19_pemeliharaan_rutin === '1',
            'p2_q20_catatan_pemupukan_pemeliharaan' => $this->p2_q20_catatan_pemupukan_pemeliharaan === '1',
            'p2_q21_pengendalian_hama_sesuai_pht' => $this->p2_q21_pengendalian_hama_sesuai_pht === '1',
            'p2_q22_sarana_pengendalian_hama' => $this->p2_q22_sarana_pengendalian_hama === '1', 
            'p2_q23_panen_buah_matang' => $this->p2_q23_panen_buah_matang === '1',
            'p2_q24_catatan_hasil_panen' => $this->p2_q24_catatan_hasil_panen === '1',
            'p2_q25_tbs_segera_diangkut' => $this->p2_q25_tbs_segera_diangkut === '1',

            // P3
            'p3_q26_upaya_mencegah_kebakaran' => $this->p3_q26_upaya_mencegah_kebakaran === '1',
            'p3_q27_mengetahui_satwa_tumbuhan' => $this->p3_q27_mengetahui_satwa_tumbuhan === '1',
            'p3_q28_mencatat_satwa_tumbuhan' => $this->p3_q28_mencatat_satwa_tumbuhan === '1',

            // P4
            'p4_q29_mendapat_info_resmi_harga' => $this->p4_q29_mendapat_info_resmi_harga === '1',
            'p4_q30_catat_harga_dan_jumlah_tbs' => $this->p4_q30_catat_harga_dan_jumlah_tbs === '1',
            'p4_q31_prosedur_pemberian_informasi' => $this->p4_q31_prosedur_pemberian_informasi === '1',
            'p4_q32_pernah_menerima_info_resmi' => $this->p4_q32_pernah_menerima_info_resmi === '1',

            // P5
            'p5_q33_rencana_perbaikan_usaha' => $this->p5_q33_rencana_perbaikan_usaha === '1',
        ];

        $this->kuisioner = Kuisioner::updateOrCreate(
            [
                'kebun_id' => $this->kebun->id,
                'user_id' => Auth::id(),
            ],
            $data
        );

        return redirect(url('/pekebun/daftar-kuisioner'))->with([
            'success' => [
                'title' => 'Data kuisioner berhasil disimpan!',
            ],
        ]);
    }

    public function render()
    {
        return view('livewire.kuisioner-form');
    }
}
