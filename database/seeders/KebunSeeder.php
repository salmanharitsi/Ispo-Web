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
        $user = User::first();

        if (! $user) {
            throw new \Exception('Tidak ada user untuk dihubungkan dengan kebun. Jalankan UserSeeder dulu.');
        }

        $kebun = [
            [
                'user_id' => $user->id,
                'nama_kebun' => 'Kebun sawit megalodon',
                'lokasi_kebun' => 'Jl taman karya no 45',
                'luas_lahan' => 4,
                'desa' => 'sukamaju',
                'kecamatan' => 'sukaramai',
                'tahun_tanam' => 2021,
                'tahun_tanam_pertama' => 2020,
                'kondisi_tanah' => 'gambut',
                'umur_tanaman' => 20,
                'jumlah_pohon' => 300,
            ],
            [
                'user_id' => $user->id,
                'nama_kebun' => 'Kebun sawit ancient',
                'lokasi_kebun' => 'Jl taman karya no 47',
                'luas_lahan' => 3.5,
                'desa' => 'sukamaju',
                'kecamatan' => 'sukaramai',
                'tahun_tanam' => 2024,
                'tahun_tanam_pertama' => 2022,
                'kondisi_tanah' => 'gambut',
                'umur_tanaman' => 17,
                'jumlah_pohon' => 200,
            ],
        ];

        foreach ($kebun as $value) {
            Kebun::create([
                'user_id' => $value['user_id'],
                'nama_kebun'=> $value['nama_kebun'],
                'lokasi_kebun'=> $value['lokasi_kebun'],
                'luas_lahan'=> $value['luas_lahan'],
                'desa'=> $value['desa'],
                'kecamatan'=> $value['kecamatan'],
                'tahun_tanam'=> $value['tahun_tanam'],
                'tahun_tanam_pertama'=> $value['tahun_tanam_pertama'],
                'kondisi_tanah'=> $value['kondisi_tanah'],
                'umur_tanaman'=> $value['umur_tanaman'],
                'jumlah_pohon'=> $value['jumlah_pohon'],
            ]);
        }
    }
}
