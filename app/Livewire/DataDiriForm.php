<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class DataDiriForm extends Component
{
    use WithFileUploads;

    public $foto_profil;
    public $existing_foto;
    public $name;
    public $email;
    public $no_hp;
    public $nik;
    public $npwp;
    public $alamat;
    public $desa;
    public $kecamatan;
    public $jumlah_anggota_keluarga;
    public $jenis_kelamin;

    protected function rules()
    {
        return [
            'foto_profil' => 'required|image|max:2048',
            'name' => 'required|string|min:3|max:255',
            'no_hp' => 'required|string|max:15',
            'nik' => 'required|string|size:16',
            'npwp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'jumlah_anggota_keluarga' => 'required|integer|min:1',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ];
    }

    protected $messages = [
        'foto_profil.image' => 'File harus berupa gambar',
        'foto_profil.max' => 'Ukuran foto maksimal 2MB',
        'name.required' => 'Nama lengkap wajib diisi',
        'fota_profil.required' => 'Foto profil wajib diunggah',
        'no_hp.required' => 'Nomor HP wajib diisi',
        'nik.required' => 'NIK wajib diisi',
        'npwp.required' => 'NPWP wajib diisi',
        'alamat.required' => 'Alamat wajib diisi',
        'desa.required' => 'Desa wajib diisi',
        'kecamatan.required' => 'Kecamatan wajib diisi',
        'jumlah_anggota_keluarga.required' => 'Jumlah anggota keluarga wajib diisi',
        'jenis_kelamin' => 'Jenis kelamin wajib diisi',
        'name.min' => 'Nama lengkap minimal 3 karakter',
        'no_hp.max' => 'Nomor HP maksimal 15 karakter',
        'nik.size' => 'NIK harus 16 digit',
        'npwp.max' => 'NPWP maksimal 20 karakter',
        'jumlah_anggota_keluarga.min' => 'Jumlah anggota keluarga minimal 1',
        'jenis_kelamin.in' => 'Pilih jenis kelamin yang valid',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->existing_foto = $user->foto_profil;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp;
        $this->nik = $user->nik;
        $this->npwp = $user->npwp;
        $this->alamat = $user->alamat;
        $this->desa = $user->desa;
        $this->kecamatan = $user->kecamatan;
        $this->jumlah_anggota_keluarga = $user->jumlah_anggota_keluarga;
        $this->jenis_kelamin = $user->jenis_kelamin;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $hasChanges = false;

        if ($this->foto_profil) {
            $hasChanges = true;
        }

        if (!$hasChanges) {
            $hasChanges = $this->name !== $user->name ||
                $this->no_hp !== $user->no_hp ||
                $this->nik !== $user->nik ||
                $this->npwp !== $user->npwp ||
                $this->alamat !== $user->alamat ||
                $this->desa !== $user->desa ||
                $this->kecamatan !== $user->kecamatan ||
                $this->jumlah_anggota_keluarga != $user->jumlah_anggota_keluarga ||
                $this->jenis_kelamin !== $user->jenis_kelamin;
        }

        if (!$hasChanges) {
            return redirect(url('/pekebun/data-diri'))->with([
                'warning' => [
                    'title' => 'Tidak ada perubahan data'
                ]
            ]);
        }

        $data = [
            'name' => $this->name,
            'no_hp' => $this->no_hp,
            'nik' => $this->nik,
            'npwp' => $this->npwp,
            'alamat' => $this->alamat,
            'desa' => $this->desa,
            'kecamatan' => $this->kecamatan,
            'jumlah_anggota_keluarga' => $this->jumlah_anggota_keluarga,
            'jenis_kelamin' => $this->jenis_kelamin,
        ];

        if ($this->foto_profil) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $data['foto_profil'] = $this->foto_profil->store('foto-profil', 'public');
            $this->existing_foto = $data['foto_profil'];
        }

        $user->update($data);

        return redirect(url('/pekebun/data-diri'))->with([
            'success' => [
                'title' => 'Data diri berhasil diperbarui!'
            ]
        ]);
    }

    public function removeFoto()
    {
        $user = Auth::user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
            $user->update(['foto_profil' => null]);
            $this->existing_foto = null;
            $this->foto_profil = null;

            return redirect(url('/pekebun/data-diri'))->with([
                'success' => [
                    'title' => 'Foto profil berhasil dihapus!'
                ]
            ]);
        }
    }

    public function render()
    {
        return view('livewire.data-diri-form');
    }
}
