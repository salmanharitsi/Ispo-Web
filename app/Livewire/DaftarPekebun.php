<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class DaftarPekebun extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public int $perPage = 10;

    public ?string $confirmingDeleteId = null;
    public ?string $detailUserId = null;
    public ?User $detailUser = null;

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

    public function confirmDelete(string $userId)
    {
        $this->confirmingDeleteId = $userId;
    }

    public function cancelDelete()
    {
        $this->confirmingDeleteId = null;
    }

    public function deleteUser()
    {
        if (! $this->confirmingDeleteId) {
            return;
        }

        // Jangan izinkan hapus akun yang sedang login
        if ((string) $this->confirmingDeleteId === (string) Auth::id()) {
            $this->confirmingDeleteId = null;
            return redirect(url('/admin/daftar-pekebun'))->with([
                'error' => [
                    'title' => 'Anda tidak dapat menghapus akun yang sedang digunakan.'
                ]
            ]);
        }

        $user = User::findOrFail($this->confirmingDeleteId);

        // FK cascade akan menghapus kebun & kuisioner terkait
        $user->delete();

        $this->confirmingDeleteId = null;
        $this->detailUserId = null;
        $this->detailUser = null;

        return redirect(url('/admin/daftar-pekebun'))->with([
            'success' => [
                'title' => 'Akun pekebun dan seluruh data terkait berhasil dihapus.'
            ]
        ]);
    }

    public function showDetail(string $userId)
    {
        // Lewati jika id = user yang sedang login
        if ((string) $userId === (string) Auth::id()) {
            return;
        }

        $this->detailUserId = $userId;

        $this->detailUser = User::with([
            'kebun' => function ($q) {
                $q->orderBy('nama_kebun');
            },
            'kebun.kuisioner',
        ])->findOrFail($userId);
    }

    public function closeDetail()
    {
        $this->detailUserId = null;
        $this->detailUser = null;
    }

    public function render()
    {
        $currentId = Auth::id();

        $query = User::query()
            // exclude user yang sedang login
            ->when($currentId, function ($q) use ($currentId) {
                $q->where('id', '!=', $currentId);
            })
            // hitung relasi kebun walaupun 0 (tidak pakai whereHas)
            ->withCount('kebun')
            ->withSum('kebun as total_luas_lahan', 'luas_lahan')
            ->withCount([
                'kebun as kebun_mapped_count' => function ($q) {
                    $q->whereNotNull('polygon');
                },
                'kebun as kebun_kuisioner_count' => function ($q) {
                    $q->has('kuisioner');
                },
                'kebun as kebun_ispo_sudah_count' => function ($q) {
                    $q->where('status_ispo', 'sudah');
                },
            ]);

        if ($this->search !== '') {
            $search = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', $search)
                  ->orWhere('email', 'like', $search)
                  ->orWhere('no_hp', 'like', $search)
                  ->orWhere('alamat', 'like', $search)
                  ->orWhere('kecamatan', 'like', $search)
                  ->orWhere('kabupaten', 'like', $search)
                  ->orWhere('kota', 'like', $search)
                  ->orWhere('pendidikan_terakhir', 'like', $search)
                  ->orWhere('tempat_lahir', 'like', $search);
            });
        }

        $pekebun = $query
            ->orderBy('name')
            ->paginate($this->perPage);

        return view('livewire.daftar-pekebun', [
            'pekebun' => $pekebun,
        ]);
    }
}
