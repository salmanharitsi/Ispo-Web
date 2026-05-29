<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AhpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seeder untuk Bobot Prinsip
        // Sesuai dengan matriks pada gambar
        $prinsipMatrix = [
            'p1' => ['p1' => 1,      'p2' => 2,      'p3' => 4,      'p4' => 6, 'p5' => 6],
            'p2' => ['p1' => 0.5,    'p2' => 1,      'p3' => 3,      'p4' => 5, 'p5' => 5],
            'p3' => ['p1' => 0.25,   'p2' => 0.3333, 'p3' => 1,      'p4' => 3, 'p5' => 3],
            'p4' => ['p1' => 0.1667, 'p2' => 0.2,    'p3' => 0.3333, 'p4' => 1, 'p5' => 1],
            'p5' => ['p1' => 0.1667, 'p2' => 0.2,    'p3' => 0.3333, 'p4' => 1, 'p5' => 1],
        ];

        $insertPrinsip = [];
        $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];
        
        // Sums
        $jumlah = [];
        foreach ($cols as $col) {
            $sum = 0;
            foreach ($cols as $row) {
                $insertPrinsip["{$row}_{$col}"] = $prinsipMatrix[$row][$col];
                $sum += $prinsipMatrix[$row][$col];
            }
            $jumlah[$col] = $sum;
            $insertPrinsip["jumlah_{$col}"] = $sum;
        }

        // Normalization & Priority Vector (Bobot)
        $bobot = [];
        foreach ($cols as $row) {
            $sumNorm = 0;
            foreach ($cols as $col) {
                $norm = $prinsipMatrix[$row][$col] / $jumlah[$col];
                $insertPrinsip["norm_{$row}_{$col}"] = $norm;
                $sumNorm += $norm;
            }
            $bobot[$row] = $sumNorm / count($cols);
            $insertPrinsip["bobot_{$row}"] = $bobot[$row];
        }

        // Matriks Penjumlahan & CV
        foreach ($cols as $row) {
            $matriksPenjumlahanBaris = 0;
            foreach ($cols as $col) {
                $val = $prinsipMatrix[$row][$col] * $bobot[$col];
                $insertPrinsip["matriks_penjumlahan_{$row}_{$col}"] = $val;
                $matriksPenjumlahanBaris += $val;
            }
            $insertPrinsip["jumlah_baris_{$row}"] = $matriksPenjumlahanBaris;
            $insertPrinsip["cv_{$row}"] = $matriksPenjumlahanBaris / $bobot[$row];
        }

        $insertPrinsip['created_at'] = now();
        $insertPrinsip['updated_at'] = now();

        DB::table('ahp_prinsips')->truncate();
        DB::table('ahp_prinsips')->insert($insertPrinsip);

        // 2. Seeder untuk Bobot Kriteria
        // Sesuai dengan matriks pada gambar yang dilampirkan
        DB::table('ahp_kriterias')->truncate();
        
        $kriteriaMatrices = [
            'p1' => [
                'k1' => ['k1' => 1,      'k2' => 3,      'k3' => 5, 'k4' => 2,      'k5' => 4],
                'k2' => ['k1' => 0.3333, 'k2' => 1,      'k3' => 3, 'k4' => 0.5,    'k5' => 2],
                'k3' => ['k1' => 0.2,    'k2' => 0.3333, 'k3' => 1, 'k4' => 0.3333, 'k5' => 0.5],
                'k4' => ['k1' => 0.5,    'k2' => 2,      'k3' => 3, 'k4' => 1,      'k5' => 3],
                'k5' => ['k1' => 0.25,   'k2' => 0.5,    'k3' => 2, 'k4' => 0.3333, 'k5' => 1]
            ],
            'p2' => [
                'k1' => ['k1' => 1, 'k2' => 1, 'k3' => 0.3333],
                'k2' => ['k1' => 1, 'k2' => 1, 'k3' => 0.3333],
                'k3' => ['k1' => 3, 'k2' => 3, 'k3' => 1]
            ],
            'p3' => [
                'k1' => ['k1' => 1,      'k2' => 3],
                'k2' => ['k1' => 0.3333, 'k2' => 1]
            ],
            'p4' => [
                'k1' => ['k1' => 1,   'k2' => 2],
                'k2' => ['k1' => 0.5, 'k2' => 1]
            ],
            'p5' => [
                'k1' => ['k1' => 1]
            ]
        ];

        $kriterias = [];
        
        foreach ($kriteriaMatrices as $pCode => $matrix) {
            $kData = ['prinsip_code' => $pCode];
            $cols = array_keys($matrix);
            
            // Sums
            $jumlah = [];
            foreach ($cols as $col) {
                $sum = 0;
                foreach ($cols as $row) {
                    $kData["{$row}_{$col}"] = $matrix[$row][$col];
                    $sum += $matrix[$row][$col];
                }
                $jumlah[$col] = $sum;
                $kData["jumlah_{$col}"] = $sum;
            }

            // Normalization & Priority Vector (Bobot)
            $bobot = [];
            foreach ($cols as $row) {
                $sumNorm = 0;
                foreach ($cols as $col) {
                    $norm = $matrix[$row][$col] / $jumlah[$col];
                    $kData["norm_{$row}_{$col}"] = $norm;
                    $sumNorm += $norm;
                }
                $bobot[$row] = $sumNorm / count($cols);
                $kData["bobot_{$row}"] = $bobot[$row];
            }

            // Matriks Penjumlahan & CV
            foreach ($cols as $row) {
                $matriksPenjumlahanBaris = 0;
                foreach ($cols as $col) {
                    $val = $matrix[$row][$col] * $bobot[$col];
                    $kData["matriks_penjumlahan_{$row}_{$col}"] = $val;
                    $matriksPenjumlahanBaris += $val;
                }
                $kData["jumlah_baris_{$row}"] = $matriksPenjumlahanBaris;
                $kData["cv_{$row}"] = $matriksPenjumlahanBaris / $bobot[$row];
            }
            
            $kData['created_at'] = now();
            $kData['updated_at'] = now();
            
            DB::table('ahp_kriterias')->insert($kData);
        }
    }
}
