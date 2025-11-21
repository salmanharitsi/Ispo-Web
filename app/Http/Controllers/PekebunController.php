<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kebun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PekebunController extends Controller
{
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

        return view('pekebun.daftar-kebun', [
            'isDataDiriComplete' => $isDataDiriComplete,
        ]);
    }

    public function get_detail_data_kebun($id)
    {
        $kebun = Kebun::findOrFail($id);

        return view('pekebun.detail-data-kebun', [
            'kebun' => $kebun,
        ]);
    }
}
