<?php

namespace App\Livewire\Admin\Topsis;

use Livewire\Component;

class PengajuanTable extends Component
{
    use \Livewire\WithPagination;
    
    public $search = '';
    public $selectedKebun = [];
    public $selectAll = false;
    
    public $showTolakModal = false;
    public $komentarPenolakan = '';
    public $tolakMode = 'single'; // single or bulk
    public $tolakId = null;

    public $detailKebunId = null;
    public $detailKebun = null;

    public function showDetail($id)
    {
        $this->detailKebunId = $id;
        $this->detailKebun = \App\Models\Kebun::with('user')->find($id);
    }

    public function closeDetail()
    {
        $this->detailKebunId = null;
        $this->detailKebun = null;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedKebun = \App\Models\Kebun::with('user')
                ->where('status_finalisasi', 'final')
                ->pluck('id')->map(fn($id) => (string) $id)->toArray();
        } else {
            $this->selectedKebun = [];
        }
    }

    public function render()
    {
        $query = \App\Models\Kebun::with('user')->where('status_finalisasi', 'final');
        
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_kebun', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($q2) {
                      $q2->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }
        
        return view('livewire.admin.topsis.pengajuan-table', [
            'kebuns' => $query->latest()->paginate(10)
        ]);
    }

    public function openTolakModal($id = null)
    {
        if ($id) {
            $this->tolakMode = 'single';
            $this->tolakId = $id;
        } else {
            if (empty($this->selectedKebun)) return;
            $this->tolakMode = 'bulk';
        }
        $this->komentarPenolakan = '';
        $this->showTolakModal = true;
    }

    public function closeTolakModal()
    {
        $this->showTolakModal = false;
        $this->komentarPenolakan = '';
        $this->tolakId = null;
    }

    public function tolakPengajuan()
    {
        $this->validate([
            'komentarPenolakan' => 'required|min:5'
        ]);

        if ($this->tolakMode === 'single') {
            $kebun = \App\Models\Kebun::find($this->tolakId);
            if ($kebun) {
                $kebun->update([
                    'status_finalisasi' => 'tolak',
                    'status_ispo' => 'belum-pengajuan',
                    'catatan_pengecekan' => $this->komentarPenolakan
                ]);
                \App\Models\TopsisRanking::where('kebun_id', $this->tolakId)->delete();
            }
        } else {
            \App\Models\Kebun::whereIn('id', $this->selectedKebun)->update([
                'status_finalisasi' => 'tolak',
                'status_ispo' => 'belum-pengajuan',
                'catatan_pengecekan' => $this->komentarPenolakan
            ]);
            \App\Models\TopsisRanking::whereIn('kebun_id', $this->selectedKebun)->delete();
            $this->selectedKebun = [];
            $this->selectAll = false;
        }

        $this->closeTolakModal();
        
        return redirect(url('/admin/topsis'))->with([
            'success' => [
                'title' => 'Pengajuan berhasil ditolak.'
            ]
        ]);
    }

    public $showSetujuModal = false;
    public $setujuMode = 'single'; // single or bulk
    public $setujuId = null;

    public function openSetujuModal($id = null)
    {
        if ($id) {
            $this->setujuMode = 'single';
            $this->setujuId = $id;
        } else {
            if (empty($this->selectedKebun)) return;
            $this->setujuMode = 'bulk';
        }
        $this->showSetujuModal = true;
    }

    public function closeSetujuModal()
    {
        $this->showSetujuModal = false;
        $this->setujuId = null;
    }

    public function terimaPengajuan()
    {
        $ids = $this->setujuMode === 'single' ? [$this->setujuId] : $this->selectedKebun;
        
        if (empty($ids)) return;

        \App\Models\Kebun::whereIn('id', $ids)->update([
            'status_finalisasi' => 'perankingan',
            'status_ispo' => 'proses',
            'catatan_pengecekan' => null
        ]);

        if ($this->setujuMode === 'bulk') {
            $this->selectedKebun = [];
            $this->selectAll = false;
        }

        // Trigger recalculate Topsis
        $this->dispatch('recalculateTopsis');
        $this->closeSetujuModal();

        return redirect(url('/admin/topsis'))->with([
            'success' => [
                'title' => count($ids) . ' pengajuan berhasil disetujui dan masuk ke perankingan.'
            ]
        ]);
    }
}
