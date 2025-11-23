<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PekebunController extends Controller
{
    protected function buildAllKebunForMap(): array
    {
        $currentUserId = Auth::id();

        return Kebun::with('user')
            ->whereNotNull('polygon') 
            ->get()
            ->map(function (Kebun $kebun) use ($currentUserId) {
                return [
                    'id'            => $kebun->id,
                    'nama_kebun'    => $kebun->nama_kebun,
                    'pemilik'       => optional($kebun->user)->name,
                    'luas_lahan'    => $kebun->luas_lahan,
                    'polygon'       => $kebun->polygon,
                    'centroid'      => [
                        $kebun->latitude,
                        $kebun->longitude,
                    ],
                    'is_current_user' => $kebun->user_id === $currentUserId,
                ];
            })
            ->values()
            ->toArray();
    }

    public function get_dashboard_pekebun()
    {
        $user = Auth::user();

        // Check Step 1: Data Diri
        $dataRequiredFields = ['name', 'no_hp', 'nik', 'npwp', 'alamat', 'desa', 'kecamatan', 'jumlah_anggota_keluarga', 'jenis_kelamin'];
        $isDataDiriComplete = true;

        foreach ($dataRequiredFields as $field) {
            if (empty($user->$field)) {
                $isDataDiriComplete = false;
                break;
            }
        }

        // Check Step 2: Data Kebun (minimal 1 kebun)
        $hasKebun = $user->kebun()->exists();
        $jumlahKebun = $user->kebun()->count();

        // Check Step 3: Pemetaan (minimal 1 kebun yang sudah dipetakan)
        $hasPemetaan = $user->kebun()->whereNotNull('polygon')->exists();
        $jumlahKebunTerpetakan = $user->kebun()->whereNotNull('polygon')->count();

        // Check Step 4: Kuisioner (minimal 1 kebun yang sudah ada kuisionernya)
        $hasKuisioner = $user->kebun()->whereHas('kuisioner')->exists();
        $jumlahKuisionerSelesai = $user->kebun()->whereHas('kuisioner')->count();

        // Check Step 5: Finalisasi (minimal 1 kebun yang sudah difinalisasi)
        $hasFinalisasi = $user->kebun()->where('status_finalisasi', 'final')->exists();
        $jumlahKebunFinalisasi = $user->kebun()->where('status_finalisasi', 'final')->count();

        // Check if all steps complete
        $allStepsComplete = $isDataDiriComplete && $hasKebun && $hasPemetaan && $hasKuisioner;

        return view('pekebun.dashboard', compact(
            'user',
            'isDataDiriComplete',
            'hasKebun',
            'jumlahKebun',
            'hasPemetaan',
            'jumlahKebunTerpetakan',
            'hasKuisioner',
            'jumlahKuisionerSelesai',
            'hasFinalisasi',
            'jumlahKebunFinalisasi',
            'allStepsComplete'
        ));
    }

    public function get_data_diri_pekebun()
    {
        return view('pekebun.data-diri');
    }

    public function get_daftar_kebun_pekebun()
    {
        $user = Auth::user();
        
        $dataRequiredFields = ['name', 'no_hp', 'nik', 'npwp', 'alamat', 'desa', 'kecamatan', 'jumlah_anggota_keluarga', 'jenis_kelamin'];
        $isDataDiriComplete = true;

        foreach ($dataRequiredFields as $field) {
            if (empty($user->$field)) {
                $isDataDiriComplete = false;
                break;
            }
        }

        $needFinalisasi = $user->kebun()->where('status_finalisasi', '=','belum')->count();

        return view('pekebun.daftar-kebun', [
            'isDataDiriComplete' => $isDataDiriComplete,
            'needFinalisasi' => $needFinalisasi,
        ]);
    }

    public function get_detail_data_kebun($id)
    {
        $kebun = Kebun::findOrFail($id);

        return view('pekebun.detail-data-kebun', [
            'kebun' => $kebun,
        ]);
    }

    public function get_daftar_pemetaan_kebun()
    {
        $user = Auth::user();
        $needPemetaan = $user->kebun()->whereNull('polygon')->count();

        return view('pekebun.daftar-pemetaan', [
            'needPemetaan'=> $needPemetaan,
        ]);
    }

    public function get_pemetaan_kebun(string $id)
    {
        $kebun = Kebun::findOrFail($id);
        $allKebun = $this->buildAllKebunForMap();

        return view('pekebun.pemetaan', [
            'kebun'    => $kebun,
            'allKebun' => $allKebun,
        ]);
    }

    public function get_allPemetaan()
    {
        $user = Auth::user();
        $allKebun = $this->buildAllKebunForMap();

        return view('pekebun.all-pemetaan', [
            'user'     => $user,
            'allKebun' => $allKebun,
        ]);
    }

    public function delete_kebun($id)
    {
        $kebun = Kebun::findOrFail($id);
        $kebun->delete();

        return redirect(url('/pekebun/daftar-kebun'))->with([
            'success' => [
                "title" => "Kebun berhasil dihapus.",
            ]
        ]);
    }

    public function post_pemetaan_kebun(Request $request, $id)
    {
        $request->validate([
            'geometry'     => 'required|string',
            'centroid_lat' => 'required|numeric',
            'centroid_lng' => 'required|numeric',
        ]);

        $kebun = Kebun::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $geometry = json_decode($request->geometry, true);

        if (!is_array($geometry) || ($geometry['type'] ?? null) !== 'Polygon') {
            return back()->withErrors(['geometry' => 'Data polygon tidak valid.']);
        }

        $kebun->polygon   = $geometry;
        $kebun->latitude  = round($request->centroid_lat, 8);
        $kebun->longitude = round($request->centroid_lng, 8);
        $kebun->save();

        return redirect(url('/pekebun/daftar-pemetaan'))->with([
            'success' => [
                "title" => "Peta lahan berhasil disimpan.",
            ]
        ]);
    }
}
