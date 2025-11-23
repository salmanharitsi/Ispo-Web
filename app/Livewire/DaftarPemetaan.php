<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarPemetaan extends Component
{
    public $search = '';
    public $nama_kebun;
    public $lokasi_kebun;
    public $luas_lahan;
    public $desa;
    public $kecamatan;
    public $tahun_tanam;
    public $tahun_tanam_pertama;
    public $kondisi_tanah;
    public $umur_tanaman;
    public $jumlah_pohon;

    public function render()
    {
        $user = Auth::user();

        
        $kebuns = $user->kebun()
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('nama_kebun', 'like', '%' . $this->search . '%')
                      ->orWhere('lokasi_kebun', 'like', '%' . $this->search . '%')
                      ->orWhere('desa', 'like', '%' . $this->search . '%')
                      ->orWhere('kecamatan', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->get();

        return view('livewire.daftar-pemetaan', [
            'kebuns' => $kebuns,
        ]);
    }
}
