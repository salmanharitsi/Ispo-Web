<?php

namespace App\Livewire;

use App\Models\Kebun;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarKebunAdmin extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public int $perPage = 10;
    public string $filterStatusIspo = '';
    public string $filterStatusFinalisasi = '';
    public string $filterPetakan = '';

    public ?string $confirmingDeleteId = null;
    public ?string $detailKebunId = null;
    public ?Kebun $detailKebun = null;

    protected $queryString = [
        'search'                 => ['except' => ''],
        'filterStatusIspo'       => ['except' => ''],
        'filterStatusFinalisasi' => ['except' => ''],
        'filterPetakan'          => ['except' => ''],
        'page'                   => ['except' => 1],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingFilterStatusIspo()
    {
        $this->resetPage();
    }

    public function updatingFilterStatusFinalisasi()
    {
        $this->resetPage();
    }

    public function updatingFilterPetakan()
    {
        $this->resetPage();
    }

    public function confirmDelete(string $kebunId)
    {
        $this->confirmingDeleteId = $kebunId;
    }

    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    public function deleteKebun()
    {
        if (! $this->confirmingDeleteId) {
            return;
        }

        $kebun = Kebun::findOrFail($this->confirmingDeleteId);
        $kebun->delete();

        $this->confirmingDeleteId = null;
        $this->detailKebunId      = null;
        $this->detailKebun        = null;

        return redirect(url('/admin/daftar-kebun'))->with([
            'success' => [
                'title' => 'Data kebun dan seluruh kuisioner terkait berhasil dihapus.'
            ]
        ]);
    }

    public function showDetail(string $kebunId)
    {
        $this->detailKebunId = $kebunId;

        $this->detailKebun = Kebun::with([
            'user',
            'kuisioner',
        ])->findOrFail($kebunId);
    }

    public function closeDetail()
    {
        $this->detailKebunId = null;
        $this->detailKebun   = null;
    }

    public function render()
    {
        $query = Kebun::query()
            ->with('user')
            ->withExists('kuisioner');

        if ($this->search !== '') {
            $search = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($search) {
                $q->where('nama_kebun', 'like', $search)
                  ->orWhere('lokasi_kebun', 'like', $search)
                  ->orWhere('desa', 'like', $search)
                  ->orWhere('kecamatan', 'like', $search)
                  ->orWhere('jenis_tanah', 'like', $search)
                  ->orWhere('jenis_bibit', 'like', $search)
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', $search)
                         ->orWhere('email', 'like', $search);
                  });
            });
        }

        if ($this->filterStatusIspo !== '') {
            $query->where('status_ispo', $this->filterStatusIspo);
        }

        if ($this->filterStatusFinalisasi !== '') {
            $query->where('status_finalisasi', $this->filterStatusFinalisasi);
        }

        if ($this->filterPetakan === 'sudah') {
            $query->whereNotNull('polygon');
        } elseif ($this->filterPetakan === 'belum') {
            $query->whereNull('polygon');
        }

        $kebun = $query
            ->orderBy('nama_kebun')
            ->paginate($this->perPage);

        return view('livewire.daftar-kebun-admin', [
            'kebun' => $kebun,
        ]);
    }
}
