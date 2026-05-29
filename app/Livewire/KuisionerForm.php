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
    public ?string $p1_q3_bebas_sengketa = null;
    public ?string $p1_q4_batas_lahan_jelas = null;
    public ?string $p1_q5_memiliki_stdb = null;
    public ?string $p1_q6_memiliki_izin_lingkungan = null;
    public ?string $p1_q7_catatan_pengelolaan_lingkungan = null;

    // PRINSIP 2
    public ?string $p2_q8_tergabung_kelompok_tani = null;
    public ?string $p2_q9_kelompok_memiliki_dokumen_resmi = null;
    public ?string $p2_q10_rencana_kerja_tertulis = null;
    public ?string $p2_q11_catatan_kegiatan_kebun = null;
    public ?string $p2_q12_buka_lahan_tanpa_bakar = null;
    public ?string $p2_q13_bibit_dari_produsen_resmi = null;
    public ?string $p2_q14_catatan_asal_bibit = null;
    public ?string $p2_q15_tanam_sesuai_standar = null;
    public ?string $p2_q16_catatan_pelaksanaan_tanam = null;
    public ?string $p2_q17_bebas_lahan_gambut = null;
    public ?string $p2_q18_pemeliharaan_rutin = null;
    public ?string $p2_q19_catatan_pemupukan_pemeliharaan = null;
    public ?string $p2_q20_pengendalian_hama_sesuai_pht = null;
    public ?string $p2_q21_sarana_pengendalian_hama = null;
    public ?string $p2_q22_panen_buah_matang = null;
    public ?string $p2_q23_catatan_hasil_panen = null;
    public ?string $p2_q24_tbs_segera_diangkut = null;

    // PRINSIP 3
    public ?string $p3_q25_upaya_mencegah_kebakaran = null;
    public ?string $p3_q26_memiliki_alat_pemadam = null;
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
            'p1_q1_surat_kepemilikan_sah' => 'required|in:0,1,2,3,4',
            'p1_q2_di_luar_kawasan_terlarang' => $bool,
            'p1_q3_bebas_sengketa' => $bool,
            'p1_q4_batas_lahan_jelas' => $bool,
            'p1_q5_memiliki_stdb' => 'required|in:0,0.5,1',
            'p1_q6_memiliki_izin_lingkungan' => $bool,
            'p1_q7_catatan_pengelolaan_lingkungan' => $bool,

            // P2
            'p2_q8_tergabung_kelompok_tani' => $bool,
            'p2_q9_kelompok_memiliki_dokumen_resmi' => $bool,
            'p2_q10_rencana_kerja_tertulis' => $bool,
            'p2_q11_catatan_kegiatan_kebun' => $bool,
            'p2_q12_buka_lahan_tanpa_bakar' => $bool,
            'p2_q13_bibit_dari_produsen_resmi' => $bool,
            'p2_q14_catatan_asal_bibit' => $bool,
            'p2_q15_tanam_sesuai_standar' => $bool,
            'p2_q16_catatan_pelaksanaan_tanam' => $bool,
            'p2_q17_bebas_lahan_gambut' => $bool,
            'p2_q18_pemeliharaan_rutin' => $bool,
            'p2_q19_catatan_pemupukan_pemeliharaan' => $bool,
            'p2_q20_pengendalian_hama_sesuai_pht' => $bool,
            'p2_q21_sarana_pengendalian_hama' => $bool,
            'p2_q22_panen_buah_matang' => $bool,
            'p2_q23_catatan_hasil_panen' => $bool,
            'p2_q24_tbs_segera_diangkut' => $bool,

            // P3
            'p3_q25_upaya_mencegah_kebakaran' => $bool,
            'p3_q26_memiliki_alat_pemadam' => $bool,
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

        // helper: true → '1', false → '0', or direct value for non-bool
        // float cast is used to correctly parse decimal strings from db (e.g., "0.0000" -> 0.0)
        $v = fn ($val) => (string) (float) $val;
        $b = fn ($val) => (float) $val > 0 ? '1' : '0';

        // P1
        $this->p1_q1_surat_kepemilikan_sah = $v($k->p1_q1_surat_kepemilikan_sah);
        $this->p1_q2_di_luar_kawasan_terlarang = $b($k->p1_q2_di_luar_kawasan_terlarang);
        $this->p1_q3_bebas_sengketa = $b($k->p1_q3_bebas_sengketa);
        $this->p1_q4_batas_lahan_jelas = $b($k->p1_q4_batas_lahan_jelas);
        $this->p1_q5_memiliki_stdb = $v($k->p1_q5_memiliki_stdb);
        $this->p1_q6_memiliki_izin_lingkungan = $b($k->p1_q6_memiliki_izin_lingkungan);
        $this->p1_q7_catatan_pengelolaan_lingkungan = $b($k->p1_q7_catatan_pengelolaan_lingkungan);

        // P2
        $this->p2_q8_tergabung_kelompok_tani = $b($k->p2_q8_tergabung_kelompok_tani);
        $this->p2_q9_kelompok_memiliki_dokumen_resmi = $b($k->p2_q9_kelompok_memiliki_dokumen_resmi);
        $this->p2_q10_rencana_kerja_tertulis = $b($k->p2_q10_rencana_kerja_tertulis);
        $this->p2_q11_catatan_kegiatan_kebun = $b($k->p2_q11_catatan_kegiatan_kebun);
        $this->p2_q12_buka_lahan_tanpa_bakar = $b($k->p2_q12_buka_lahan_tanpa_bakar);
        $this->p2_q13_bibit_dari_produsen_resmi = $b($k->p2_q13_bibit_dari_produsen_resmi);
        $this->p2_q14_catatan_asal_bibit = $b($k->p2_q14_catatan_asal_bibit);
        $this->p2_q15_tanam_sesuai_standar = $b($k->p2_q15_tanam_sesuai_standar);
        $this->p2_q16_catatan_pelaksanaan_tanam = $b($k->p2_q16_catatan_pelaksanaan_tanam);
        $this->p2_q17_bebas_lahan_gambut = $b($k->p2_q17_bebas_lahan_gambut);
        $this->p2_q18_pemeliharaan_rutin = $b($k->p2_q18_pemeliharaan_rutin);
        $this->p2_q19_catatan_pemupukan_pemeliharaan = $b($k->p2_q19_catatan_pemupukan_pemeliharaan);
        $this->p2_q20_pengendalian_hama_sesuai_pht = $b($k->p2_q20_pengendalian_hama_sesuai_pht);
        $this->p2_q21_sarana_pengendalian_hama = $b($k->p2_q21_sarana_pengendalian_hama);  
        $this->p2_q22_panen_buah_matang = $b($k->p2_q22_panen_buah_matang);
        $this->p2_q23_catatan_hasil_panen = $b($k->p2_q23_catatan_hasil_panen);
        $this->p2_q24_tbs_segera_diangkut = $b($k->p2_q24_tbs_segera_diangkut);

        // P3
        $this->p3_q25_upaya_mencegah_kebakaran = $b($k->p3_q25_upaya_mencegah_kebakaran);
        $this->p3_q26_memiliki_alat_pemadam = $b($k->p3_q26_memiliki_alat_pemadam);
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
            'p1_q1_surat_kepemilikan_sah' => $this->p1_q1_surat_kepemilikan_sah,
            'p1_q2_di_luar_kawasan_terlarang' => $this->p1_q2_di_luar_kawasan_terlarang === '1',
            'p1_q3_bebas_sengketa' => $this->p1_q3_bebas_sengketa === '1',
            'p1_q4_batas_lahan_jelas' => $this->p1_q4_batas_lahan_jelas === '1',
            'p1_q5_memiliki_stdb' => $this->p1_q5_memiliki_stdb,
            'p1_q6_memiliki_izin_lingkungan' => $this->p1_q6_memiliki_izin_lingkungan === '1',
            'p1_q7_catatan_pengelolaan_lingkungan' => $this->p1_q7_catatan_pengelolaan_lingkungan === '1',

            // P2
            'p2_q8_tergabung_kelompok_tani' => $this->p2_q8_tergabung_kelompok_tani === '1',
            'p2_q9_kelompok_memiliki_dokumen_resmi' => $this->p2_q9_kelompok_memiliki_dokumen_resmi === '1',
            'p2_q10_rencana_kerja_tertulis' => $this->p2_q10_rencana_kerja_tertulis === '1',
            'p2_q11_catatan_kegiatan_kebun' => $this->p2_q11_catatan_kegiatan_kebun === '1',
            'p2_q12_buka_lahan_tanpa_bakar' => $this->p2_q12_buka_lahan_tanpa_bakar === '1',
            'p2_q13_bibit_dari_produsen_resmi' => $this->p2_q13_bibit_dari_produsen_resmi === '1',
            'p2_q14_catatan_asal_bibit' => $this->p2_q14_catatan_asal_bibit === '1',
            'p2_q15_tanam_sesuai_standar' => $this->p2_q15_tanam_sesuai_standar === '1',
            'p2_q16_catatan_pelaksanaan_tanam' => $this->p2_q16_catatan_pelaksanaan_tanam === '1',
            'p2_q17_bebas_lahan_gambut' => $this->p2_q17_bebas_lahan_gambut === '1',
            'p2_q18_pemeliharaan_rutin' => $this->p2_q18_pemeliharaan_rutin === '1',
            'p2_q19_catatan_pemupukan_pemeliharaan' => $this->p2_q19_catatan_pemupukan_pemeliharaan === '1',
            'p2_q20_pengendalian_hama_sesuai_pht' => $this->p2_q20_pengendalian_hama_sesuai_pht === '1',
            'p2_q21_sarana_pengendalian_hama' => $this->p2_q21_sarana_pengendalian_hama === '1', 
            'p2_q22_panen_buah_matang' => $this->p2_q22_panen_buah_matang === '1',
            'p2_q23_catatan_hasil_panen' => $this->p2_q23_catatan_hasil_panen === '1',
            'p2_q24_tbs_segera_diangkut' => $this->p2_q24_tbs_segera_diangkut === '1',

            // P3
            'p3_q25_upaya_mencegah_kebakaran' => $this->p3_q25_upaya_mencegah_kebakaran === '1',
            'p3_q26_memiliki_alat_pemadam' => $this->p3_q26_memiliki_alat_pemadam === '1',
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

        if ($this->kebun->status_finalisasi === 'perankingan') {
            $this->kebun->status_finalisasi = 'revisi';
            $this->kebun->status_ispo = 'belum-pengajuan';
            $this->kebun->catatan_pengecekan = 'Data kuisioner telah diubah. Silakan ajukan ulang agar dapat diperiksa kembali oleh Admin.';
            $this->kebun->save();
            \App\Models\TopsisRanking::where('kebun_id', $this->kebun->id)->delete();
        }

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
