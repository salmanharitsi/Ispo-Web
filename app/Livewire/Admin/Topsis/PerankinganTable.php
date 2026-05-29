<?php

namespace App\Livewire\Admin\Topsis;

use Livewire\Component;

class PerankinganTable extends Component
{
    use \Livewire\WithPagination;

    public $search = '';

    public $detailKebunId = null;
    public $detailKebun = null;

    public function showDetail($id)
    {
        $this->detailKebunId = $id;
        $this->detailKebun = \App\Models\Kebun::with('user')->find($id);
    }

    public function closeDetail()
    {
        $this->detailKebunId = null;
        $this->detailKebun = null;
    }

    protected $listeners = ['recalculateTopsis' => 'calculateTopsis'];

    public function render()
    {
        $query = \App\Models\TopsisRanking::with(['kebun.user']);
        
        if ($this->search) {
            $query->whereHas('kebun', function($q) {
                $q->where('nama_kebun', 'like', '%'.$this->search.'%')
                  ->orWhereHas('user', function($q2) {
                      $q2->where('name', 'like', '%'.$this->search.'%');
                  });
            });
        }

        $allVi = \App\Models\TopsisRanking::whereNotNull('vi')
            ->orderByDesc('vi')
            ->pluck('vi')
            ->unique()
            ->values();

        $totalKebun = \App\Models\Kebun::where('status_finalisasi', 'perankingan')->count();

        return view('livewire.admin.topsis.perankingan-table', [
            'rankings' => $query->orderByDesc('vi')->paginate(10),
            'allVi' => $allVi,
            'totalKebun' => $totalKebun,
        ]);
    }

    public function calculateTopsis()
    {
        // 1. Ambil bobot final (33 soal)
        $ahpFinal = \App\Models\AhpFinal::first();
        if (!$ahpFinal) return;

        // 2. Ambil bobot Prinsip untuk A+ dan A-
        $ahpPrinsip = \App\Models\AhpPrinsip::first();
        if (!$ahpPrinsip) return;
        $w = [
            'p1' => $ahpPrinsip->bobot_p1,
            'p2' => $ahpPrinsip->bobot_p2,
            'p3' => $ahpPrinsip->bobot_p3,
            'p4' => $ahpPrinsip->bobot_p4,
            'p5' => $ahpPrinsip->bobot_p5,
        ];

        // 3. Ambil semua kebun dengan status finalisasi = perankingan
        $kebuns = \App\Models\Kebun::with('kuisioner')->where('status_finalisasi', 'perankingan')->get();
        if ($kebuns->isEmpty()) return;

        $matrix = [];
        foreach ($kebuns as $kebun) {
            $k = $kebun->kuisioner;
            if (!$k) continue;

            $matrix[$kebun->id] = [
                'p1' => 0, 'p2' => 0, 'p3' => 0, 'p4' => 0, 'p5' => 0
            ];

            // P1 (q1 - q7)
            $matrix[$kebun->id]['p1'] += ($k->p1_q1_surat_kepemilikan_sah / 4) * $ahpFinal->q1;
            $matrix[$kebun->id]['p1'] += $k->p1_q2_di_luar_kawasan_terlarang * $ahpFinal->q2;
            $matrix[$kebun->id]['p1'] += $k->p1_q3_dokumen_penyelesaian_sengketa * $ahpFinal->q3;
            $matrix[$kebun->id]['p1'] += $k->p1_q4_salinan_perjanjian_sengketa * $ahpFinal->q4;
            $matrix[$kebun->id]['p1'] += $k->p1_q5_memiliki_stdb * $ahpFinal->q5;
            $matrix[$kebun->id]['p1'] += $k->p1_q6_memiliki_izin_lingkungan * $ahpFinal->q6;
            $matrix[$kebun->id]['p1'] += $k->p1_q7_catatan_pengelolaan_lingkungan * $ahpFinal->q7;

            // P2 (q8 - q24)
            $matrix[$kebun->id]['p2'] += $k->p2_q8_tergabung_kelompok_tani * $ahpFinal->q8;
            $matrix[$kebun->id]['p2'] += $k->p2_q9_kelompok_memiliki_dokumen_resmi * $ahpFinal->q9;
            $matrix[$kebun->id]['p2'] += $k->p2_q10_rencana_kerja_tertulis * $ahpFinal->q10;
            $matrix[$kebun->id]['p2'] += $k->p2_q11_catatan_kegiatan_kebun * $ahpFinal->q11;
            $matrix[$kebun->id]['p2'] += $k->p2_q12_buka_lahan_tanpa_bakar * $ahpFinal->q12;
            $matrix[$kebun->id]['p2'] += $k->p2_q13_bibit_dari_produsen_resmi * $ahpFinal->q13;
            $matrix[$kebun->id]['p2'] += $k->p2_q14_catatan_asal_bibit * $ahpFinal->q14;
            $matrix[$kebun->id]['p2'] += $k->p2_q15_tanam_sesuai_standar * $ahpFinal->q15;
            $matrix[$kebun->id]['p2'] += $k->p2_q16_catatan_pelaksanaan_tanam * $ahpFinal->q16;
            $matrix[$kebun->id]['p2'] += $k->p2_q17_panduan_lahan_gambut * $ahpFinal->q17;
            $matrix[$kebun->id]['p2'] += $k->p2_q18_pemeliharaan_rutin * $ahpFinal->q18;
            $matrix[$kebun->id]['p2'] += $k->p2_q19_catatan_pemupukan_pemeliharaan * $ahpFinal->q19;
            $matrix[$kebun->id]['p2'] += $k->p2_q20_pengendalian_hama_sesuai_pht * $ahpFinal->q20;
            $matrix[$kebun->id]['p2'] += $k->p2_q21_sarana_pengendalian_hama * $ahpFinal->q21;
            $matrix[$kebun->id]['p2'] += $k->p2_q22_panen_buah_matang * $ahpFinal->q22;
            $matrix[$kebun->id]['p2'] += $k->p2_q23_catatan_hasil_panen * $ahpFinal->q23;
            $matrix[$kebun->id]['p2'] += $k->p2_q24_tbs_segera_diangkut * $ahpFinal->q24;

            // P3 (q25 - q28)
            $matrix[$kebun->id]['p3'] += $k->p3_q25_upaya_mencegah_kebakaran * $ahpFinal->q25;
            $matrix[$kebun->id]['p3'] += $k->p3_q26_memiliki_alat_pemadam * $ahpFinal->q26;
            $matrix[$kebun->id]['p3'] += $k->p3_q27_mengetahui_satwa_tumbuhan * $ahpFinal->q27;
            $matrix[$kebun->id]['p3'] += $k->p3_q28_mencatat_satwa_tumbuhan * $ahpFinal->q28;

            // P4 (q29 - q32)
            $matrix[$kebun->id]['p4'] += $k->p4_q29_mendapat_info_resmi_harga * $ahpFinal->q29;
            $matrix[$kebun->id]['p4'] += $k->p4_q30_catat_harga_dan_jumlah_tbs * $ahpFinal->q30;
            $matrix[$kebun->id]['p4'] += $k->p4_q31_prosedur_pemberian_informasi * $ahpFinal->q31;
            $matrix[$kebun->id]['p4'] += $k->p4_q32_pernah_menerima_info_resmi * $ahpFinal->q32;

            // P5 (q33)
            $matrix[$kebun->id]['p5'] += $k->p5_q33_rencana_perbaikan_usaha * $ahpFinal->q33;
        }

        // FUNGSI 1: SKOR ABSOLUT (Dijalankan untuk semua pekebun)
        // Hitung nilai maksimal per prinsip (berdasarkan bobot AHP Final)
        $max_p1 = $ahpFinal->q1 + $ahpFinal->q2 + $ahpFinal->q3 + $ahpFinal->q4 + $ahpFinal->q5 + $ahpFinal->q6 + $ahpFinal->q7;
        $max_p2 = $ahpFinal->q8 + $ahpFinal->q9 + $ahpFinal->q10 + $ahpFinal->q11 + $ahpFinal->q12 + $ahpFinal->q13 + $ahpFinal->q14 + $ahpFinal->q15 + $ahpFinal->q16 + $ahpFinal->q17 + $ahpFinal->q18 + $ahpFinal->q19 + $ahpFinal->q20 + $ahpFinal->q21 + $ahpFinal->q22 + $ahpFinal->q23 + $ahpFinal->q24;
        $max_p3 = $ahpFinal->q25 + $ahpFinal->q26 + $ahpFinal->q27 + $ahpFinal->q28;
        $max_p4 = $ahpFinal->q29 + $ahpFinal->q30 + $ahpFinal->q31 + $ahpFinal->q32;
        $max_p5 = $ahpFinal->q33;
        $total_maks = $max_p1 + $max_p2 + $max_p3 + $max_p4 + $max_p5;

        $skorAbsolut = [];
        foreach ($kebuns as $kebun) {
            $id = $kebun->id;
            $total_aktual = $matrix[$id]['p1'] + $matrix[$id]['p2'] + $matrix[$id]['p3'] + $matrix[$id]['p4'] + $matrix[$id]['p5'];
            
            // Rumus Skor Absolut (%)
            $skor = $total_maks > 0 ? ($total_aktual / $total_maks) * 100 : 0;
            $skorAbsolut[$id] = $skor;

            // Status ISPO berdasarkan Skor Absolut
            $statusIspo = 'belum-layak';
            if ($skor >= 70) {
                $statusIspo = 'sudah-layak';
            } elseif ($skor >= 56) {
                $statusIspo = 'cukup-layak';
            }

            \App\Models\Kebun::where('id', $id)->update(['status_ispo' => $statusIspo]);
        }

        // FUNGSI 2: TOPSIS (Hanya untuk Perangkingan, skip jika < 2 pekebun)
        if ($kebuns->count() < 2) {
            foreach ($kebuns as $kebun) {
                $id = $kebun->id;
                \App\Models\TopsisRanking::updateOrCreate(
                    ['kebun_id' => $id],
                    [
                        'p1_score' => $matrix[$id]['p1'],
                        'p2_score' => $matrix[$id]['p2'],
                        'p3_score' => $matrix[$id]['p3'],
                        'p4_score' => $matrix[$id]['p4'],
                        'p5_score' => $matrix[$id]['p5'],
                        'd_plus' => null,
                        'd_min' => null,
                        'vi' => null, // null = TOPSIS tidak dijalankan
                        'skor' => $skorAbsolut[$id]
                    ]
                );
            }
            if ($kebuns->count() === 0) {
                session()->flash('warning', 'Belum ada data pekebun.');
            } else {
                session()->flash('warning', 'Ranking tidak tersedia (butuh minimal 2 pekebun). Skor Absolut tetap dihitung.');
            }
            return;
        }

        // Lanjutkan perhitungan TOPSIS jika >= 2
        // 4. Hitung Pembagi Normalisasi (Akar Jumlah Kuadrat) per kolom
        $pembagi = ['p1' => 0, 'p2' => 0, 'p3' => 0, 'p4' => 0, 'p5' => 0];
        foreach (['p1','p2','p3','p4','p5'] as $p) {
            $sumSq = 0;
            foreach ($matrix as $id => $row) {
                $sumSq += pow($row[$p], 2);
            }
            $pembagi[$p] = sqrt($sumSq);
        }

        // 5. Normalisasi Matrix dan Hitung Matriks Keputusan Ternormalisasi Terbobot (Y)
        $yMatrix = [];
        $idealPositif = ['p1' => -999, 'p2' => -999, 'p3' => -999, 'p4' => -999, 'p5' => -999];
        $idealNegatif = ['p1' => 999, 'p2' => 999, 'p3' => 999, 'p4' => 999, 'p5' => 999];

        foreach ($matrix as $id => $row) {
            $yMatrix[$id] = [];
            foreach (['p1','p2','p3','p4','p5'] as $p) {
                $normalized = $pembagi[$p] > 0 ? $row[$p] / $pembagi[$p] : 0;
                $weighted = $normalized * $w[$p];
                $yMatrix[$id][$p] = $weighted;

                if ($weighted > $idealPositif[$p]) $idealPositif[$p] = $weighted;
                if ($weighted < $idealNegatif[$p]) $idealNegatif[$p] = $weighted;
            }
        }

        // 6. Hitung Jarak Solusi Ideal Positif (D+) dan Negatif (D-) dan Nilai Preferensi (Vi)
        foreach ($yMatrix as $id => $row) {
            $dPlusSq = 0;
            $dMinSq = 0;
            foreach (['p1','p2','p3','p4','p5'] as $p) {
                $dPlusSq += pow($row[$p] - $idealPositif[$p], 2);
                $dMinSq += pow($row[$p] - $idealNegatif[$p], 2);
            }
            $dPlus = sqrt($dPlusSq);
            $dMin = sqrt($dMinSq);

            $vi = ($dPlus + $dMin) > 0 ? $dMin / ($dPlus + $dMin) : 0;

            // Simpan ke TopsisRanking (skor absolut disimpan di 'skor')
            \App\Models\TopsisRanking::updateOrCreate(
                ['kebun_id' => $id],
                [
                    'p1_score' => $matrix[$id]['p1'],
                    'p2_score' => $matrix[$id]['p2'],
                    'p3_score' => $matrix[$id]['p3'],
                    'p4_score' => $matrix[$id]['p4'],
                    'p5_score' => $matrix[$id]['p5'],
                    'd_plus' => $dPlus,
                    'd_min' => $dMin,
                    'vi' => $vi,
                    'skor' => $skorAbsolut[$id]
                ]
            );
        }
        
        session()->flash('success', 'Kalkulasi Skor Absolut dan Perangkingan TOPSIS berhasil dilakukan.');
    }
}
