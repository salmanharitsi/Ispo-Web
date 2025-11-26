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
}
