<?php

namespace App\Livewire;

use App\Models\Kebun;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DaftarKebun extends Component
{
    public $showModal = false;
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

    protected $listeners = ['openModal'];

    protected function rules()
    {
        return [
            'nama_kebun' => 'required|string|max:255',
            'lokasi_kebun' => 'required|string|max:255',
            'luas_lahan' => 'required|numeric|min:0.01',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'tahun_tanam' => 'required|integer|min:1900|max:' . date('Y'),
            'tahun_tanam_pertama' => 'required|integer|min:1900|max:' . date('Y'),
            'kondisi_tanah' => 'required|string|max:255',
            'umur_tanaman' => 'required|integer|min:0',
            'jumlah_pohon' => 'required|integer|min:0',
        ];
    }

    protected $messages = [
        'nama_kebun.required' => 'Nama kebun wajib diisi',
        'lokasi_kebun.required' => 'Lokasi kebun wajib diisi',
        'luas_lahan.required' => 'Luas lahan wajib diisi',
        'desa.required' => 'Desa wajib diisi',
        'kecamatan.required' => 'Kecamatan wajib diisi',
        'tahun_tanam.required' => 'Tahun tanam wajib diisi',
        'tahun_tanam_pertama.required' => 'Tahun tanam pertama wajib diisi',
        'kondisi_tanah.required' => 'Kondisi tanah wajib diisi',
        'umur_tanaman.required' => 'Umur tanaman wajib diisi',
        'jumlah_pohon' => 'Jumlah pohon wajib diisi',
        'luas_lahan.numeric' => 'Luas lahan harus berupa angka',
        'luas_lahan.min' => 'Luas lahan minimal 0.01 hektar',
        'tahun_tanam.min' => 'Tahun tanam tidak valid',
        'tahun_tanam.max' => 'Tahun tanam tidak boleh melebihi tahun ini',
        'umur_tanaman.min' => 'Umur tanaman tidak valid',
        'jumlah_pohon.min' => 'Jumlah pohon tidak valid',
    ];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'nama_kebun',
            'lokasi_kebun',
            'luas_lahan',
            'desa',
            'kecamatan',
            'tahun_tanam',
            'tahun_tanam_pertama',
            'kondisi_tanah',
            'umur_tanaman',
            'jumlah_pohon'
        ]);
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();

        Kebun::create([
            'user_id' => $user->id,
            'nama_kebun' => $this->nama_kebun,
            'lokasi_kebun' => $this->lokasi_kebun,
            'luas_lahan' => $this->luas_lahan,
            'desa' => $this->desa,
            'kecamatan' => $this->kecamatan,
            'tahun_tanam' => $this->tahun_tanam,
            'tahun_tanam_pertama' => $this->tahun_tanam_pertama,
            'kondisi_tanah' => $this->kondisi_tanah,
            'umur_tanaman' => $this->umur_tanaman,
            'jumlah_pohon' => $this->jumlah_pohon,
        ]);

        return redirect(url('/pekebun/daftar-kebun'))->with([
            'success' => [
                'title' => 'Data kebun berhasil ditambahkan!',
            ],
        ]);
    }

    public function render()
    {
        $user = Auth::user();
        
        // Query dengan search filter
        $kebuns = Auth::user()->kebun()
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

        $dataRequiredFields = ['name', 'no_hp', 'nik', 'npwp', 'alamat', 'desa', 'kecamatan', 'jumlah_anggota_keluarga', 'jenis_kelamin'];
        $isDataDiriComplete = true;

        foreach ($dataRequiredFields as $field) {
            if (empty($user->$field)) {
                $isDataDiriComplete = false;
                break;
            }
        }

        return view('livewire.daftar-kebun', [
            'kebuns' => $kebuns,
            'isDataDiriComplete' => $isDataDiriComplete,
        ]);
    }
}