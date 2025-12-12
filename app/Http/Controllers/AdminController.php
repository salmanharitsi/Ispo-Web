<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function get_dashboard_admin()
    {
        $user = Auth::user();

        // Angka-angka utama
        $totalKebun       = Kebun::count();
        $totalPekebun     = User::whereHas('kebun')->count();
        $totalLuas        = Kebun::sum('luas_lahan');
        $kebunMapped      = Kebun::whereNotNull('polygon')->count();
        $kebunKuisioner   = Kebun::has('kuisioner')->count();
        $kebunLengkap     = Kebun::whereNotNull('polygon')->has('kuisioner')->count();
        $kebunFinal       = Kebun::where('status_finalisasi', 'final')->count();

        $ispoBelum    = Kebun::where('status_ispo', 'belum')->count();
        $ispoProses   = Kebun::where('status_ispo', 'proses')->count();
        $ispoSudah    = Kebun::where('status_ispo', 'sudah')->count();

        // Kebun per kecamatan (top 6)
        $kecamatanData = Kebun::select('kecamatan', DB::raw('COUNT(*) as total'))
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $kecamatanLabels = $kecamatanData->pluck('kecamatan');
        $kecamatanCounts = $kecamatanData->pluck('total');

        return view('admin.dashboard', compact(
            'user',
            'totalKebun',
            'totalPekebun',
            'totalLuas',
            'kebunMapped',
            'kebunKuisioner',
            'kebunLengkap',
            'kebunFinal',
            'kecamatanLabels',
            'kecamatanCounts',
            'ispoBelum',
            'ispoProses',
            'ispoSudah',
        ));
    }

    public function get_daftar_pekebun()
    {
        return view('admin.daftar-pekebun');
    }

    public function get_pengajuan_ispo()
    {
        return view('admin.pengajuan-ispo');
    }

    public function get_detail_pengajuan_ispo($id)
    {
        $kebun = Kebun::with(['user', 'kuisioner'])->findOrFail($id);
        $kuisioner = $kebun->kuisioner;

        // --- KUISIONER: mapping field per prinsip ---

        $p1Fields = [
            'p1_q1_surat_kepemilikan_sah',
            'p1_q2_di_luar_kawasan_terlarang',
            'p1_q3_dokumen_penyelesaian_sengketa',
            'p1_q4_salinan_perjanjian_sengketa',
            'p1_q5_memiliki_stdb',
            'p1_q6_sedang_mengurus_stdb',
            'p1_q7_memiliki_izin_lingkungan',
            'p1_q8_catatan_pengelolaan_lingkungan',
        ];

        $p2Fields = [
            'p2_q9_tergabung_kelompok_tani',
            'p2_q10_kelompok_memiliki_dokumen_resmi',
            'p2_q11_rencana_kerja_tertulis',
            'p2_q12_catatan_kegiatan_kebun',
            'p2_q13_buka_lahan_tanpa_bakar',
            'p2_q14_bibit_dari_produsen_resmi',
            'p2_q15_catatan_asal_bibit',
            'p2_q16_tanam_sesuai_standar',
            'p2_q17_catatan_pelaksanaan_tanam',
            'p2_q18_panduan_lahan_gambut',
            'p2_q19_pemeliharaan_rutin',
            'p2_q20_catatan_pemupukan_pemeliharaan',
            'p2_q21_pengendalian_hama_sesuai_pht',
            'p2_q22_sarana_pengendalian_hama',
            'p2_q23_panen_buah_matang',
            'p2_q24_catatan_hasil_panen',
            'p2_q25_tbs_segera_diangkut',
        ];

        $p3Fields = [
            'p3_q26_upaya_mencegah_kebakaran',
            'p3_q27_mengetahui_satwa_tumbuhan',
            'p3_q28_mencatat_satwa_tumbuhan',
        ];

        $p4Fields = [
            'p4_q29_mendapat_info_resmi_harga',
            'p4_q30_catat_harga_dan_jumlah_tbs',
            'p4_q31_prosedur_pemberian_informasi',
            'p4_q32_pernah_menerima_info_resmi',
        ];

        $p5Fields = [
            'p5_q33_rencana_perbaikan_usaha',
        ];

        $computeStats = function ($fields, $bobotPerSoal) use ($kuisioner) {
            $total = count($fields);
            $yes = 0;

            if ($kuisioner) {
                foreach ($fields as $field) {
                    if ($kuisioner->$field) {
                        $yes++;
                    }
                }
            }

            $no = $total - $yes;
            $percentage = $total > 0 ? round(($yes / $total) * 100) : 0;
            
            // Hitung bobot yang diperoleh
            $bobotDiperoleh = $yes * $bobotPerSoal;

            return compact('total', 'yes', 'no', 'percentage', 'bobotDiperoleh');
        };

        $kuisionerSummary = [
            'p1' => array_merge(
                [
                    'kode' => 'P1',
                    'nama' => 'Kepatuhan terhadap Peraturan & Legalitas',
                    'bobotPerSoal' => 6.425,
                    'jumlahSoal' => 8,
                ],
                $computeStats($p1Fields, 6.425)
            ),
            'p2' => array_merge(
                [
                    'kode' => 'P2',
                    'nama' => 'Praktik Budidaya & Manajemen Kebun',
                    'bobotPerSoal' => 1.935,
                    'jumlahSoal' => 17,
                ],
                $computeStats($p2Fields, 1.935)
            ),
            'p3' => array_merge(
                [
                    'kode' => 'P3',
                    'nama' => 'Lingkungan & Keanekaragaman Hayati',
                    'bobotPerSoal' => 1.528,
                    'jumlahSoal' => 3,
                ],
                $computeStats($p3Fields, 1.528)
            ),
            'p4' => array_merge(
                [
                    'kode' => 'P4',
                    'nama' => 'Transparansi Penjualan & Informasi',
                    'bobotPerSoal' => 0.567,
                    'jumlahSoal' => 4,
                ],
                $computeStats($p4Fields, 0.567)
            ),
            'p5' => array_merge(
                [
                    'kode' => 'P5',
                    'nama' => 'Peningkatan Usaha & Keberlanjutan Kebun',
                    'bobotPerSoal' => 0.993,
                    'jumlahSoal' => 1,
                ],
                $computeStats($p5Fields, 0.993)
            ),
        ];

        $totalQuestionAll = array_sum(array_column($kuisionerSummary, 'total'));
        $yesAll           = array_sum(array_column($kuisionerSummary, 'yes'));
        $overallPercentage = $totalQuestionAll > 0
            ? round(($yesAll / $totalQuestionAll) * 100)
            : 0;
        
        // Total bobot kuisioner yang diperoleh (maksimal 75%)
        $totalBobotKuisioner = array_sum(array_column($kuisionerSummary, 'bobotDiperoleh'));

        // --- Data indikator kebun untuk SPK (sesuai tabel) ---

        $kebunIndicators = [
            [
                'kode'       => 'K1',
                'nama'       => 'Nama Kebun',
                'keterangan' => 'Identifikasi dasar',
                'nilai'      => $kebun->nama_kebun ?: '-',
                'status'     => $kebun->nama_kebun ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
            [
                'kode'       => 'K2',
                'nama'       => 'Lokasi Kebun',
                'keterangan' => 'Desa/Kecamatan/Koordinat',
                'nilai'      => $kebun->kecamatan ?: '-',
                'status'     => $kebun->kecamatan ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
            [
                'kode'       => 'K3',
                'nama'       => 'Luas Lahan (ha)',
                'keterangan' => 'Input penting legalitas & produksi',
                'nilai'      => $kebun->luas_lahan ? number_format($kebun->luas_lahan, 2, ',', '.') . ' Ha' : '-',
                'status'     => $kebun->luas_lahan ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
            [
                'kode'       => 'K4',
                'nama'       => 'Tahun Tanam / Umur Tanaman',
                'keterangan' => 'Memastikan umur di ISPO (produktif)',
                'nilai'      => $kebun->tahun_tanam ?: '-',
                'status'     => $kebun->tahun_tanam ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
            [
                'kode'       => 'K5',
                'nama'       => 'Status Lahan',
                'keterangan' => 'Milik sendiri/warisan/sewa',
                'nilai'      => $kebun->status_lahan ?: '-',
                'status'     => $kebun->status_lahan ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
            [
                'kode'       => 'K6',
                'nama'       => 'Jenis Tanah (mineral/gambut)',
                'keterangan' => 'Dibutuhkan di ISPO (kelolaan gambut)',
                'nilai'      => $kebun->jenis_tanah ?: '-',
                'status'     => $kebun->jenis_tanah ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
            [
                'kode'       => 'K7',
                'nama'       => 'Asal Lahan',
                'keterangan' => 'Bekas karet/ladang/hutan dll',
                'nilai'      => $kebun->asal_lahan ?: '-',
                'status'     => $kebun->asal_lahan ? 'Terisi' : 'Belum Terisi',
                'bobot'      => 3.57,
            ],
        ];

        // Hitung total bobot data kebun yang diperoleh
        $totalBobotKebun = 0;
        foreach ($kebunIndicators as $indicator) {
            if ($indicator['status'] === 'Terisi') {
                $totalBobotKebun += $indicator['bobot'];
            }
        }

        // Total nilai AHP (kuisioner + kebun)
        $totalNilaiAHP = $totalBobotKuisioner + $totalBobotKebun;
        $totalNilaiPersentase = round($totalNilaiAHP, 2);
        $totalNilaiDesimal = round($totalNilaiAHP / 100, 3);

        // --- (Opsional) mapping pertanyaan kuisioner untuk tabel detail ---

        $kuisionerQuestions = [
            [
                'kode'   => 'P1.1',
                'prinsip'=> 'P1',
                'indikator' => 'Legalitas lahan',
                'field'  => 'p1_q1_surat_kepemilikan_sah',
                'label'  => 'Memiliki surat kepemilikan lahan yang sah',
            ],
            [
                'kode'   => 'P1.2',
                'prinsip'=> 'P1',
                'indikator' => 'Lokasi kebun sesuai aturan',
                'field'  => 'p1_q2_di_luar_kawasan_terlarang',
                'label'  => 'Kebun berada di luar kawasan terlarang',
            ],
        ];

        return view('admin.detail-pengajuan-ispo', [
            'kebun'                  => $kebun,
            'kuisioner'              => $kuisioner,
            'kuisionerSummary'       => $kuisionerSummary,
            'overallPercentage'      => $overallPercentage,
            'kebunIndicators'        => $kebunIndicators,
            'kuisionerQuestions'     => $kuisionerQuestions,
            'totalBobotKuisioner'    => $totalBobotKuisioner,
            'totalBobotKebun'        => $totalBobotKebun,
            'totalNilaiAHP'          => $totalNilaiAHP,
            'totalNilaiPersentase'   => $totalNilaiPersentase,
            'totalNilaiDesimal'      => $totalNilaiDesimal,
        ]);
    }

    public function tolak_sertifikasi(Request $request, $id)
    {
        $request->validate([
            'komentar_tolak' => 'required|string|max:1000',
        ]);

        $kebun = Kebun::findOrFail($id);
        $kebun->status_ispo = 'belum';
        $kebun->komentar_tolak = $request->komentar_tolak;
        $kebun->save();

        return redirect()->route('admin.pengajuan-ispo')->with('success', 'Sertifikasi berhasil ditolak');
    }

    public function setujui_sertifikasi($id)
    {
        $kebun = Kebun::findOrFail($id);
        $kebun->status_ispo = 'sudah';
        $kebun->save();

        return redirect()->route('admin.pengajuan-ispo')->with('success', 'Sertifikasi berhasil disetujui');
    }
}