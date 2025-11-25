<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarKuisioner extends Component
{
    public $search = '';
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

        return view('livewire.daftar-kuisioner',[
            'kebuns' => $kebuns,
        ]);
    }
}
