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
    public $jumlah_pohon;

    // field baru
    public $jenis_tanah;
    public $asal_lahan;
    public $status_lahan;
    public $dokumen_kepemilikan_lahan;
    public $jenis_bibit;
    public $frekuensi_panen;
    public $harga_jual_tbs_terakhir; // dipakai untuk harga TBS terakhir (Rp/kg)
    public $pendapatan_bersih;       // pendapatan bersih per bulan (Rp)
    public $kepada_siapa_hasil_panen_dijual;

    protected $listeners = ['openModal'];

    protected function rules()
    {
        $currentYear = date('Y');

        return [
            'nama_kebun'  => 'required|string|max:255',
            'lokasi_kebun' => 'required|string|max:255',
            'luas_lahan'  => 'required|numeric|min:0.01',
            'desa'        => 'required|string|max:255',
            'kecamatan'   => 'required|string|max:255',
            'tahun_tanam' => "required|integer|min:1900|max:{$currentYear}",
            'jumlah_pohon' => 'required|integer|min:0',

            'jenis_tanah' => 'required|in:mineral,gambut',
            'asal_lahan'  => 'required|in:bekas hutan,bekas karet,ladang lama,lainnya',
            'status_lahan' => 'required|in:milik sendiri,sewa,warisan,lainnya',
            'dokumen_kepemilikan_lahan' => 'required|in:surat hak milik,surat keterangan tanah/surat jual beli,tidak punya dokumen',
            'jenis_bibit' => 'required|in:bersertifikat,tidak bersertifikat',
            'frekuensi_panen' => 'required|integer|max:100',
            'harga_jual_tbs_terakhir' => 'required|integer|min:0',
            'pendapatan_bersih' => 'required|integer|min:0',
            'kepada_siapa_hasil_panen_dijual' => 'required|in:RAM,PKS langsung',
        ];
    }

    protected $messages = [
        'nama_kebun.required' => 'Nama kebun wajib diisi',
        'lokasi_kebun.required' => 'Lokasi kebun wajib diisi',
        'luas_lahan.required' => 'Luas lahan wajib diisi',
        'desa.required' => 'Desa wajib diisi',
        'kecamatan.required' => 'Kecamatan wajib diisi',
        'tahun_tanam.required' => 'Tahun tanam wajib diisi',
        'jumlah_pohon.required' => 'Jumlah pohon wajib diisi',

        'luas_lahan.numeric' => 'Luas lahan harus berupa angka',
        'luas_lahan.min' => 'Luas lahan minimal 0.01 hektar',
        'tahun_tanam.min' => 'Tahun tanam tidak valid',
        'tahun_tanam.max' => 'Tahun tanam tidak boleh melebihi tahun ini',
        'jumlah_pohon.min' => 'Jumlah pohon tidak valid',

        'jenis_tanah.required' => 'Jenis tanah wajib dipilih',
        'jenis_tanah.in' => 'Jenis tanah tidak valid',
        'asal_lahan.required' => 'Asal lahan wajib dipilih',
        'asal_lahan.in' => 'Asal lahan tidak valid',
        'status_lahan.required' => 'Status lahan wajib dipilih',
        'status_lahan.in' => 'Status lahan tidak valid',
        'dokumen_kepemilikan_lahan.required' => 'Dokumen kepemilikan lahan wajib dipilih',
        'dokumen_kepemilikan_lahan.in' => 'Dokumen kepemilikan lahan tidak valid',
        'jenis_bibit.required' => 'Jenis bibit wajib dipilih',
        'jenis_bibit.in' => 'Jenis bibit tidak valid',
        'frekuensi_panen.required' => 'Frekuensi panen wajib diisi',
        'harga_jual_tbs_terakhir.required' => 'Harga jual TBS terakhir wajib diisi',
        'harga_jual_tbs_terakhir.integer' => 'Harga jual TBS terakhir harus berupa angka',
        'harga_jual_tbs_terakhir.min' => 'Harga jual TBS terakhir tidak valid',
        'pendapatan_bersih.required' => 'Pendapatan bersih wajib diisi',
        'pendapatan_bersih.integer' => 'Pendapatan bersih harus berupa angka',
        'pendapatan_bersih.min' => 'Pendapatan bersih tidak valid',
        'kepada_siapa_hasil_panen_dijual.required' => 'Tujuan penjualan hasil panen wajib dipilih',
        'kepada_siapa_hasil_panen_dijual.in' => 'Tujuan penjualan hasil panen tidak valid',
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
            'jumlah_pohon',
            'jenis_tanah',
            'asal_lahan',
            'status_lahan',
            'dokumen_kepemilikan_lahan',
            'jenis_bibit',
            'frekuensi_panen',
            'harga_jual_tbs_terakhir',
            'pendapatan_bersih',
            'kepada_siapa_hasil_panen_dijual',
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
            'jumlah_pohon' => $this->jumlah_pohon,

            'jenis_tanah' => $this->jenis_tanah,
            'asal_lahan' => $this->asal_lahan,
            'status_lahan' => $this->status_lahan,
            'dokumen_kepemilikan_lahan' => $this->dokumen_kepemilikan_lahan,
            'jenis_bibit' => $this->jenis_bibit,
            'frekuensi_panen' => $this->frekuensi_panen,
            'harga_jual_tbs_terakhir' => $this->harga_jual_tbs_terakhir,
            'pendapatan_bersih' => $this->pendapatan_bersih,
            'kepada_siapa_hasil_panen_dijual' => $this->kepada_siapa_hasil_panen_dijual,
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

        $dataRequiredFields = [
            'name',
            'no_hp',
            'tempat_lahir',
            'tanggal_lahir',
            'pendidikan_terakhir',
            'alamat',
            'rt_rw',
            'kecamatan',
            'kabupaten',
            'kota',
            'foto_profil',
            'jumlah_anggota_keluarga',
            'jenis_kelamin',
        ];

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
