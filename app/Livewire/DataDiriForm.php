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

    public $tempat_lahir;
    public $tanggal_lahir;
    public $pendidikan_terakhir;

    public $alamat;
    public $rt;
    public $rw;
    public $kecamatan;
    public $kabupaten;
    public $kota;

    public $jumlah_anggota_keluarga;
    public $jenis_kelamin;

    protected function rules()
    {
        return [
            'foto_profil'               => 'required|image|max:2048',
            'name'                      => 'required|string|min:3|max:255',
            'no_hp'                     => 'required|string|max:15',
            'tempat_lahir'              => 'required|string|max:255',
            'tanggal_lahir'             => 'required|date',
            'pendidikan_terakhir'       => 'required|string|max:50',
            'alamat'                    => 'required|string',
            'rt'                        => 'required|string|max:5',
            'rw'                        => 'required|string|max:5',
            'kecamatan'                 => 'required|string|max:255',
            'kabupaten'                 => 'required|string|max:255',
            'kota'                      => 'required|string|max:255',
            'jumlah_anggota_keluarga'   => 'required|integer|min:1',
            'jenis_kelamin'             => 'required|in:Laki-laki,Perempuan',
        ];
    }

    protected $messages = [
        'foto_profil.image'                  => 'File harus berupa gambar.',
        'foto_profil.max'                    => 'Ukuran foto maksimal 2MB.',
        'foto_profil.required'               => 'Foto profil wajib diisi',
        'name.required'                      => 'Nama lengkap wajib diisi.',
        'name.min'                           => 'Nama lengkap minimal 3 karakter.',
        'no_hp.required'                     => 'Nomor HP wajib diisi.',
        'no_hp.max'                          => 'Nomor HP maksimal 15 karakter.',
        'tempat_lahir.required'              => 'Tempat lahir wajib diisi',
        'tanggal_lahir.required'             => 'Tanggal lahir wajib diisi',
        'pendidikan_terakhir.required'       => 'Pendidikan terakhir wajib diisi',
        'rt.required'                        => 'RT wajib diisi',
        'rw.required'                        => 'RW wajib diisi',
        'alamat.required'                    => 'Alamat wajib diisi.',
        'kecamatan.required'                 => 'Kecamatan wajib diisi.',
        'kabupaten.required'                 => 'Kabupaten wajib diisi.',
        'kota.required'                      => 'Kota wajib diisi.',
        'jumlah_anggota_keluarga.required'   => 'Jumlah anggota keluarga wajib diisi.',
        'jumlah_anggota_keluarga.min'        => 'Jumlah anggota keluarga minimal 1.',
        'jenis_kelamin.required'             => 'Jenis kelamin wajib diisi.',
        'jenis_kelamin.in'                   => 'Pilih jenis kelamin yang valid.',
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->existing_foto             = $user->foto_profil;
        $this->name                      = $user->name;
        $this->email                     = $user->email;
        $this->no_hp                     = $user->no_hp;

        $this->tempat_lahir              = $user->tempat_lahir;
        $this->tanggal_lahir             = $user->tanggal_lahir;
        $this->pendidikan_terakhir       = $user->pendidikan_terakhir;

        $this->alamat                    = $user->alamat;
        $this->kecamatan                 = $user->kecamatan;
        $this->kabupaten                 = $user->kabupaten;
        $this->kota                      = $user->kota;

        $this->jumlah_anggota_keluarga   = $user->jumlah_anggota_keluarga;
        $this->jenis_kelamin             = $user->jenis_kelamin;

        // Parsing rt_rw => rt, rw
        $this->rt = null;
        $this->rw = null;
        if ($user->rt_rw) {
            [$rt, $rw] = array_pad(explode('/', $user->rt_rw), 2, '');
            $this->rt = $rt;
            $this->rw = $rw;
        }
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

        if (! $hasChanges) {
            $currentRtRw = $user->rt_rw ?? null;
            $newRtRw = null;
            if (trim((string) $this->rt) !== '' || trim((string) $this->rw) !== '') {
                $newRtRw = trim((string) $this->rt) . '/' . trim((string) $this->rw);
            }

            $hasChanges = $this->name !== $user->name ||
                $this->no_hp !== $user->no_hp ||
                $this->tempat_lahir !== $user->tempat_lahir ||
                $this->tanggal_lahir !== $user->tanggal_lahir ||
                $this->pendidikan_terakhir !== $user->pendidikan_terakhir ||
                $this->alamat !== $user->alamat ||
                $newRtRw !== $currentRtRw ||
                $this->kecamatan !== $user->kecamatan ||
                $this->kabupaten !== $user->kabupaten ||
                $this->kota !== $user->kota ||
                (int) $this->jumlah_anggota_keluarga !== (int) $user->jumlah_anggota_keluarga ||
                $this->jenis_kelamin !== $user->jenis_kelamin;
        }

        if (! $hasChanges) {
            return redirect(url('/pekebun/data-diri'))->with([
                'warning' => [
                    'title' => 'Tidak ada perubahan data',
                ],
            ]);
        }

        // Build rt_rw string
        $rtRw = null;
        if (trim((string) $this->rt) !== '' || trim((string) $this->rw) !== '') {
            $rt = trim((string) $this->rt);
            $rw = trim((string) $this->rw);
            // Kalau mau auto padding 3 digit:
            // $rt = str_pad(preg_replace('/\D/', '', $rt), 3, '0', STR_PAD_LEFT);
            // $rw = str_pad(preg_replace('/\D/', '', $rw), 3, '0', STR_PAD_LEFT);
            $rtRw = $rt . '/' . $rw;
        }

        $data = [
            'name'                      => $this->name,
            'no_hp'                     => $this->no_hp,
            'tempat_lahir'              => $this->tempat_lahir,
            'tanggal_lahir'             => $this->tanggal_lahir,
            'pendidikan_terakhir'       => $this->pendidikan_terakhir,
            'alamat'                    => $this->alamat,
            'rt_rw'                     => $rtRw,
            'kecamatan'                 => $this->kecamatan,
            'kabupaten'                 => $this->kabupaten,
            'kota'                      => $this->kota,
            'jumlah_anggota_keluarga'   => $this->jumlah_anggota_keluarga,
            'jenis_kelamin'             => $this->jenis_kelamin,
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
                'title' => 'Data diri berhasil diperbarui!',
            ],
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
                    'title' => 'Foto profil berhasil dihapus!',
                ],
            ]);
        }
    }

    public function render()
    {
        return view('livewire.data-diri-form');
    }
}
