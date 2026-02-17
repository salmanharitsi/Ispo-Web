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
                    'status_ispo'     => $kebun->status_ispo ?? 'belum',
                ];
            })
            ->values()
            ->toArray();
    }

    public function get_dashboard_pekebun()
    {
        $user = Auth::user();

        // Check Step 1: Data Diri
        $dataRequiredFields = ['name', 'no_hp','tempat_lahir', 'tanggal_lahir', 'pendidikan_terakhir', 'alamat', 'rt_rw', 'kecamatan', 'kabupaten', 'kota', 'foto_profil', 'jumlah_anggota_keluarga', 'jenis_kelamin'];
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

        // Check Step 5: Kuisioner (minimal 1 kebun yang sudah ada kuisionernya)
        $hasPernyataanStdb = $user->kebun()->where('pernyataan_stdb', true)->exists();
        $jumlahPernyataanStdb = $user->kebun()->where('pernyataan_stdb', true)->count();

        // Check Step 6: Finalisasi (minimal 1 kebun yang sudah difinalisasi)
        $hasFinalisasi = $user->kebun()->where('status_finalisasi', 'final')->exists();
        $jumlahKebunFinalisasi = $user->kebun()->where('status_finalisasi', 'final')->count();

        // Check if all steps complete
        $allStepsComplete = $isDataDiriComplete && $hasKebun && $hasPemetaan && $hasKuisioner && $hasPernyataanStdb && $hasFinalisasi;

        return view('pekebun.dashboard', compact(
            'user',
            'isDataDiriComplete',
            'hasKebun',
            'jumlahKebun',
            'hasPemetaan',
            'jumlahKebunTerpetakan',
            'hasKuisioner',
            'jumlahKuisionerSelesai',
            'hasPernyataanStdb',
            'jumlahPernyataanStdb',
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
        
        $dataRequiredFields = ['name', 'no_hp','tempat_lahir', 'tanggal_lahir', 'pendidikan_terakhir', 'alamat', 'rt_rw', 'kecamatan', 'kabupaten', 'kota', 'foto_profil', 'jumlah_anggota_keluarga', 'jenis_kelamin'];
        $isDataDiriComplete = true;

        foreach ($dataRequiredFields as $field) {
            if (empty($user->$field)) {
                $isDataDiriComplete = false;
                break;
            }
        }

        $needSTDB = $user->kebun()
            ->where('polygon', '!=', null)
            ->whereHas('kuisioner')
            ->where('pernyataan_stdb','=', false)
            ->count();

        $needFinalisasi = $user->kebun()
            ->where('status_finalisasi', '=','belum')
            ->where('polygon', '!=', null)
            ->where('pernyataan_stdb','=', true)
            ->whereHas('kuisioner')
            ->count();

        return view('pekebun.daftar-kebun', [
            'isDataDiriComplete' => $isDataDiriComplete,
            'needFinalisasi' => $needFinalisasi,
            'needSTDB'=> $needSTDB,
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

        if ($kebun->status_finalisasi == "final") {
            return redirect()->back();
        }

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

    public function get_daftar_kuisioner_kebun()
    {
        $user = Auth::user();
        $needKuisioner = $user->kebun()
        ->doesntHave('kuisioner')   
        ->count();

        return view('pekebun.daftar-kuisioner', [
            'needKuisioner'=> $needKuisioner,
        ]);
    }

    public function get_kuisioner_kebun(string $id)
    {
        $kebun = Kebun::findOrFail($id);

        if ($kebun->status_finalisasi == "final") {
            return redirect()->back();
        }

        return view('pekebun.kuisioner', [
            'kebun'    => $kebun,
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
            'polygon_sides' => 'required|json',
            'centroid_lat' => 'required|numeric',
            'centroid_lng' => 'required|numeric',
            'area_m2' => 'required|numeric',
            'area_hectare' => 'required|numeric',
            'perimeter_m' => 'required|numeric',
        ]);

        $kebun = Kebun::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $geometry = json_decode($request->geometry, true);

        if (!is_array($geometry) || ($geometry['type'] ?? null) !== 'Polygon') {
            return back()->withErrors(['geometry' => 'Data polygon tidak valid.']);
        }

        $kebun->polygon   = $geometry;
        $kebun->polygon_sides = json_decode($request->polygon_sides, true);
        $kebun->centroid = [
            'lat' => round($request->centroid_lat, 8),
            'lng' => round($request->centroid_lng, 8),
        ];
        $kebun->area_m2 = $request->area_m2;
        $kebun->area_hectare = $request->area_hectare;
        $kebun->perimeter_m = $request->perimeter_m;
        $kebun->latitude  = round($request->centroid_lat, 8);
        $kebun->longitude = round($request->centroid_lng, 8);
        $kebun->save();

        return redirect(url('/pekebun/daftar-pemetaan'))->with([
            'success' => [
                "title" => "Peta lahan berhasil disimpan.",
            ]
        ]);
    }

    public function post_finalisasiKebun(string $id)
    {
        $user = Auth::user();

        $kebun = Kebun::where('id', $id)
            ->where('user_id', $user->id)
            ->with(['kuisioner'])
            ->firstOrFail();

        // Optional: cegah finalisasi ulang
        if ($kebun->status_finalisasi === 'final') {
            return redirect(url('/pekebun/daftar-kebun'))->with([
                'error' => [
                    "title" => "Data kebun ini sudah difinalisasi sebelumnya.",
                ]
            ]);
        }

        // Optional: pastikan data lengkap dulu
        if (!$kebun->polygon || !$kebun->kuisioner || $kebun->pernyataan_stdb == false) {
            return redirect(url('/pekebun/daftar-kebun'))->with([
                'error' => [
                    "title" => "Data kebun belum lengkap. Lengkapi pemetaan, kuisioner, dan pernyataan STDB sebelum finalisasi.",
                ]
            ]);
        }

        $kebun->status_finalisasi = 'final';
        $kebun->status_ispo = 'proses';
        $kebun->save();

        return redirect(url('/pekebun/daftar-kebun/' . $kebun->id))->with([
            'success' => [
                "title" => "Data kebun berhasil difinalisasi. Data tidak dapat diubah lagi.",
            ]
        ]);
    }

    public function post_pernyataanStdb(string $id)
    {
        $user = Auth::user();

        $kebun = Kebun::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Optional: cegah finalisasi ulang
        if ($kebun->pernyataan_stdb === true) {
            return redirect(url('/pekebun/daftar-kebun'))->with([
                'error' => [
                    "title" => "Data kebun ini sudah memiliki pernyataan STDB.",
                ]
            ]);
        }

        // Optional: pastikan data lengkap dulu
        if (!$kebun->polygon || !$kebun->kuisioner) {
            return redirect(url('/pekebun/daftar-kebun'))->with([
                'error' => [
                    "title" => "Data kebun belum lengkap. Lengkapi pemetaan dan kuisioner sebelum finalisasi.",
                ]
            ]);
        }

        $kebun->pernyataan_stdb = true;
        $kebun->save();

        return redirect(url('/pekebun/daftar-kebun/' . $kebun->id))->with([
            'success' => [
                "title" => "Berhasil mengisi pernyataan STDB untuk kebun ini.",
            ]
        ]);
    }
}
