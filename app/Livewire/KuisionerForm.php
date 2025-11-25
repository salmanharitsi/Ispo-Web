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
    public ?string $p1_dokumen_kepemilikan_sah = null;
    public ?string $p1_batas_lahan_jelas = null;
    public ?string $p1_di_luar_kawasan_hutan = null;
    public ?string $p1_memiliki_stdb = null;
    public ?string $p1_tidak_dalam_sengketa = null;
    public ?string $p1_tahu_aturan_pemerintah = null;

    // PRINSIP 2
    public ?string $p2_bibit_bersertifikat = null;
    public ?string $p2_catatan_pemupukan = null;
    public ?string $p2_pemupukan_sesuai_kebutuhan = null;
    public ?string $p2_panen_rutin = null;
    public ?string $p2_rawat_piringan_tpt = null;
    public ?string $p2_kendali_gulma_tanpa_bakar = null;
    public ?string $p2_pengendalian_hama_sesuai_anjuran = null;
    public ?string $p2_pestisida_sesuai_label = null;
    public ?string $p2_catatan_produksi_tbs = null;
    public ?string $p2_tahu_standar_mutu_tbs = null;

    // PRINSIP 3
    public ?string $p3_memiliki_sppl = null;
    public ?string $p3_kelola_limbah_kebun_benar = null;
    public ?string $p3_hindari_bakar_lahan = null;
    public ?string $p3_jaga_sumber_air = null;
    public ?string $p3_hindari_pestisida_terlarang = null;
    public ?string $p3_area_konservasi_kecil = null;

    // PRINSIP 4
    public ?string $p4_tergabung_kelompok_tani = null;
    public ?string $p4_kelompok_aktif_pembinaan = null;
    public ?string $p4_pelatihan_budidaya_sawit = null;
    public ?string $p4_pelatihan_ispo = null;
    public ?string $p4_tahu_manfaat_ispo = null;
    public ?string $p4_catat_biaya_usaha = null;
    public ?string $p4_catat_pendapatan_tbs = null;

    // PRINSIP 5
    public ?string $p5_pendapatan_cukup = null;
    public ?string $p5_siap_sertifikasi_ispo = null;
    public ?string $p5_kesulitan_biaya_pemeliharaan = null;
    public ?string $p5_butuh_dukungan_pembiayaan = null;

    protected function rules(): array
    {
        $bool = 'required|in:0,1';

        return [
            // P1
            'p1_dokumen_kepemilikan_sah' => $bool,
            'p1_batas_lahan_jelas' => $bool,
            'p1_di_luar_kawasan_hutan' => $bool,
            'p1_memiliki_stdb' => $bool,
            'p1_tidak_dalam_sengketa' => $bool,
            'p1_tahu_aturan_pemerintah' => $bool,

            // P2
            'p2_bibit_bersertifikat' => $bool,
            'p2_catatan_pemupukan' => $bool,
            'p2_pemupukan_sesuai_kebutuhan' => $bool,
            'p2_panen_rutin' => $bool,
            'p2_rawat_piringan_tpt' => $bool,
            'p2_kendali_gulma_tanpa_bakar' => $bool,
            'p2_pengendalian_hama_sesuai_anjuran' => $bool,
            'p2_pestisida_sesuai_label' => $bool,
            'p2_catatan_produksi_tbs' => $bool,
            'p2_tahu_standar_mutu_tbs' => $bool,

            // P3
            'p3_memiliki_sppl' => $bool,
            'p3_kelola_limbah_kebun_benar' => $bool,
            'p3_hindari_bakar_lahan' => $bool,
            'p3_jaga_sumber_air' => $bool,
            'p3_hindari_pestisida_terlarang' => $bool,
            'p3_area_konservasi_kecil' => $bool,

            // P4
            'p4_tergabung_kelompok_tani' => $bool,
            'p4_kelompok_aktif_pembinaan' => $bool,
            'p4_pelatihan_budidaya_sawit' => $bool,
            'p4_pelatihan_ispo' => $bool,
            'p4_tahu_manfaat_ispo' => $bool,
            'p4_catat_biaya_usaha' => $bool,
            'p4_catat_pendapatan_tbs' => $bool,

            // P5
            'p5_pendapatan_cukup' => $bool,
            'p5_siap_sertifikasi_ispo' => $bool,
            'p5_kesulitan_biaya_pemeliharaan' => $bool,
            'p5_butuh_dukungan_pembiayaan' => $bool,
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
        $this->p1_dokumen_kepemilikan_sah = $b($k->p1_dokumen_kepemilikan_sah);
        $this->p1_batas_lahan_jelas = $b($k->p1_batas_lahan_jelas);
        $this->p1_di_luar_kawasan_hutan = $b($k->p1_di_luar_kawasan_hutan);
        $this->p1_memiliki_stdb = $b($k->p1_memiliki_stdb);
        $this->p1_tidak_dalam_sengketa = $b($k->p1_tidak_dalam_sengketa);
        $this->p1_tahu_aturan_pemerintah = $b($k->p1_tahu_aturan_pemerintah);

        // P2
        $this->p2_bibit_bersertifikat = $b($k->p2_bibit_bersertifikat);
        $this->p2_catatan_pemupukan = $b($k->p2_catatan_pemupukan);
        $this->p2_pemupukan_sesuai_kebutuhan = $b($k->p2_pemupukan_sesuai_kebutuhan);
        $this->p2_panen_rutin = $b($k->p2_panen_rutin);
        $this->p2_rawat_piringan_tpt = $b($k->p2_rawat_piringan_tpt);
        $this->p2_kendali_gulma_tanpa_bakar = $b($k->p2_kendali_gulma_tanpa_bakar);
        $this->p2_pengendalian_hama_sesuai_anjuran = $b($k->p2_pengendalian_hama_sesuai_anjuran);
        $this->p2_pestisida_sesuai_label = $b($k->p2_pestisida_sesuai_label);
        $this->p2_catatan_produksi_tbs = $b($k->p2_catatan_produksi_tbs);
        $this->p2_tahu_standar_mutu_tbs = $b($k->p2_tahu_standar_mutu_tbs);

        // P3
        $this->p3_memiliki_sppl = $b($k->p3_memiliki_sppl);
        $this->p3_kelola_limbah_kebun_benar = $b($k->p3_kelola_limbah_kebun_benar);
        $this->p3_hindari_bakar_lahan = $b($k->p3_hindari_bakar_lahan);
        $this->p3_jaga_sumber_air = $b($k->p3_jaga_sumber_air);
        $this->p3_hindari_pestisida_terlarang = $b($k->p3_hindari_pestisida_terlarang);
        $this->p3_area_konservasi_kecil = $b($k->p3_area_konservasi_kecil);

        // P4
        $this->p4_tergabung_kelompok_tani = $b($k->p4_tergabung_kelompok_tani);
        $this->p4_kelompok_aktif_pembinaan = $b($k->p4_kelompok_aktif_pembinaan);
        $this->p4_pelatihan_budidaya_sawit = $b($k->p4_pelatihan_budidaya_sawit);
        $this->p4_pelatihan_ispo = $b($k->p4_pelatihan_ispo);
        $this->p4_tahu_manfaat_ispo = $b($k->p4_tahu_manfaat_ispo);
        $this->p4_catat_biaya_usaha = $b($k->p4_catat_biaya_usaha);
        $this->p4_catat_pendapatan_tbs = $b($k->p4_catat_pendapatan_tbs);

        // P5
        $this->p5_pendapatan_cukup = $b($k->p5_pendapatan_cukup);
        $this->p5_siap_sertifikasi_ispo = $b($k->p5_siap_sertifikasi_ispo);
        $this->p5_kesulitan_biaya_pemeliharaan = $b($k->p5_kesulitan_biaya_pemeliharaan);
        $this->p5_butuh_dukungan_pembiayaan = $b($k->p5_butuh_dukungan_pembiayaan);
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'kebun_id' => $this->kebun->id,

            // P1
            'p1_dokumen_kepemilikan_sah' => $this->p1_dokumen_kepemilikan_sah === '1',
            'p1_batas_lahan_jelas' => $this->p1_batas_lahan_jelas === '1',
            'p1_di_luar_kawasan_hutan' => $this->p1_di_luar_kawasan_hutan === '1',
            'p1_memiliki_stdb' => $this->p1_memiliki_stdb === '1',
            'p1_tidak_dalam_sengketa' => $this->p1_tidak_dalam_sengketa === '1',
            'p1_tahu_aturan_pemerintah' => $this->p1_tahu_aturan_pemerintah === '1',

            // P2
            'p2_bibit_bersertifikat' => $this->p2_bibit_bersertifikat === '1',
            'p2_catatan_pemupukan' => $this->p2_catatan_pemupukan === '1',
            'p2_pemupukan_sesuai_kebutuhan' => $this->p2_pemupukan_sesuai_kebutuhan === '1',
            'p2_panen_rutin' => $this->p2_panen_rutin === '1',
            'p2_rawat_piringan_tpt' => $this->p2_rawat_piringan_tpt === '1',
            'p2_kendali_gulma_tanpa_bakar' => $this->p2_kendali_gulma_tanpa_bakar === '1',
            'p2_pengendalian_hama_sesuai_anjuran' => $this->p2_pengendalian_hama_sesuai_anjuran === '1',
            'p2_pestisida_sesuai_label' => $this->p2_pestisida_sesuai_label === '1',
            'p2_catatan_produksi_tbs' => $this->p2_catatan_produksi_tbs === '1',
            'p2_tahu_standar_mutu_tbs' => $this->p2_tahu_standar_mutu_tbs === '1',

            // P3
            'p3_memiliki_sppl' => $this->p3_memiliki_sppl === '1',
            'p3_kelola_limbah_kebun_benar' => $this->p3_kelola_limbah_kebun_benar === '1',
            'p3_hindari_bakar_lahan' => $this->p3_hindari_bakar_lahan === '1',
            'p3_jaga_sumber_air' => $this->p3_jaga_sumber_air === '1',
            'p3_hindari_pestisida_terlarang' => $this->p3_hindari_pestisida_terlarang === '1',
            'p3_area_konservasi_kecil' => $this->p3_area_konservasi_kecil === '1',

            // P4
            'p4_tergabung_kelompok_tani' => $this->p4_tergabung_kelompok_tani === '1',
            'p4_kelompok_aktif_pembinaan' => $this->p4_kelompok_aktif_pembinaan === '1',
            'p4_pelatihan_budidaya_sawit' => $this->p4_pelatihan_budidaya_sawit === '1',
            'p4_pelatihan_ispo' => $this->p4_pelatihan_ispo === '1',
            'p4_tahu_manfaat_ispo' => $this->p4_tahu_manfaat_ispo === '1',
            'p4_catat_biaya_usaha' => $this->p4_catat_biaya_usaha === '1',
            'p4_catat_pendapatan_tbs' => $this->p4_catat_pendapatan_tbs === '1',

            // P5
            'p5_pendapatan_cukup' => $this->p5_pendapatan_cukup === '1',
            'p5_siap_sertifikasi_ispo' => $this->p5_siap_sertifikasi_ispo === '1',
            'p5_kesulitan_biaya_pemeliharaan' => $this->p5_kesulitan_biaya_pemeliharaan === '1',
            'p5_butuh_dukungan_pembiayaan' => $this->p5_butuh_dukungan_pembiayaan === '1',
        ];

        $this->kuisioner = Kuisioner::updateOrCreate(
            [
                'kebun_id' => $this->kebun->id,
                'user_id' => Auth::id(),
            ],
            $data
        );

        return redirect(url('/pekebun/daftar-pemetaan'))->with([
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
