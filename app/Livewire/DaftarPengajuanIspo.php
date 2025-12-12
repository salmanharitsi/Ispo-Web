<?php

namespace App\Livewire;

use App\Models\Kebun;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPengajuanIspo extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'page'   => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Kebun::with('user')
            ->where('status_finalisasi', 'final')
            ->where('status_ispo', 'proses');

        if ($this->search !== '') {
            $search = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($search) {
                // cari di kolom kebun
                $q->where('nama_kebun', 'like', $search)
                  ->orWhere('lokasi_kebun', 'like', $search)
                  ->orWhere('desa', 'like', $search)
                  ->orWhere('kecamatan', 'like', $search)
                  // cari di relasi user (pemilik)
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', $search)
                         ->orWhere('email', 'like', $search)
                         ->orWhere('no_hp', 'like', $search);
                  });
            });
        }

        $pengajuan = $query
            ->orderBy('nama_kebun')
            ->paginate($this->perPage);

        return view('livewire.daftar-pengajuan-ispo', [
            'pengajuan' => $pengajuan,
        ]);
    }
}
