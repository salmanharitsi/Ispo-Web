<?php

namespace Database\Seeders;

use App\Models\Kebun;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class KebunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('role', 'pekebun')->first();

        if (! $user) {
            throw new \Exception('Tidak ada user untuk dihubungkan dengan kebun. Jalankan UserSeeder dulu.');
        }

        $kebun = [
            [
                'user_id' => $user->id,
                'nama_kebun' => 'Kebun sawit megalodon',
                'lokasi_kebun' => 'Jl taman karya no 45',
                'desa' => 'sukamaju',
                'kecamatan' => 'sukaramai',
                'luas_lahan' => 4,
                'tahun_tanam' => 2021,
                'jumlah_pohon' => 300,
                'jenis_tanah' => 'gambut',
                'asal_lahan' => 'bekas hutan',
                'status_lahan' => 'milik sendiri',
                'dokumen_kepemilikan_lahan' => 'surat hak milik',
                'jenis_bibit' => 'bersertifikat',
                'frekuensi_panen' => 14,
                'harga_jual_tbs_terakhir' => 2500,
                'pendapatan_bersih' => 3000000,
                'kepada_siapa_hasil_panen_dijual' => 'RAM'
            ],
            [
                'user_id' => $user->id,
                'nama_kebun' => 'Kebun sawit ancient',
                'lokasi_kebun' => 'Jl taman karya no 47',
                'desa' => 'sukamaju',
                'kecamatan' => 'sukaramai',
                'luas_lahan' => 3.5,
                'tahun_tanam' => 2024,
                'jumlah_pohon' => 200,
                'jenis_tanah' => 'gambut',
                'asal_lahan' => 'bekas hutan',
                'status_lahan' => 'milik sendiri',
                'dokumen_kepemilikan_lahan' => 'surat hak milik',
                'jenis_bibit' => 'bersertifikat',
                'frekuensi_panen' => 10,
                'harga_jual_tbs_terakhir' => 2700,
                'pendapatan_bersih' => 3500000,
                'kepada_siapa_hasil_panen_dijual' => 'PKS langsung'
            ],
        ];

        foreach ($kebun as $value) {
            Kebun::create([
                'user_id' => $value['user_id'],
                'nama_kebun'=> $value['nama_kebun'],
                'lokasi_kebun'=> $value['lokasi_kebun'],
                'desa'=> $value['desa'],
                'kecamatan'=> $value['kecamatan'],
                'luas_lahan'=> $value['luas_lahan'],
                'tahun_tanam'=> $value['tahun_tanam'],
                'jumlah_pohon'=> $value['jumlah_pohon'],
                'jenis_tanah'=> $value['jenis_tanah'],
                'asal_lahan'=> $value['asal_lahan'],
                'status_lahan'=> $value['status_lahan'],
                'dokumen_kepemilikan_lahan'=> $value['dokumen_kepemilikan_lahan'],
                'jenis_bibit'=> $value['jenis_bibit'],
                'frekuensi_panen'=> $value['frekuensi_panen'],
                'harga_jual_tbs_terakhir'=> $value['harga_jual_tbs_terakhir'],
                'pendapatan_bersih'=> $value['pendapatan_bersih'],
                'kepada_siapa_hasil_panen_dijual'=> $value['kepada_siapa_hasil_panen_dijual'],
            ]);
        }
    }
}
