<?php

namespace App\Livewire\Admin\Ahp;

use Livewire\Component;
use App\Models\AhpPrinsip;

class PrinsipTable extends Component
{
    public $matrix = [
        'p1' => ['p1' => null, 'p2' => null, 'p3' => null, 'p4' => null, 'p5' => null],
        'p2' => ['p1' => null, 'p2' => null, 'p3' => null, 'p4' => null, 'p5' => null],
        'p3' => ['p1' => null, 'p2' => null, 'p3' => null, 'p4' => null, 'p5' => null],
        'p4' => ['p1' => null, 'p2' => null, 'p3' => null, 'p4' => null, 'p5' => null],
        'p5' => ['p1' => null, 'p2' => null, 'p3' => null, 'p4' => null, 'p5' => null],
    ];

    public $jumlah = ['p1' => 0, 'p2' => 0, 'p3' => 0, 'p4' => 0, 'p5' => 0];

    public $norm = [];
    public $bobot = [];
    public $matriks_penjumlahan = [];
    public $jumlah_baris = [];
    public $cv = [];
    
    public $norm_jumlah = ['p1' => 0, 'p2' => 0, 'p3' => 0, 'p4' => 0, 'p5' => 0];
    public $isGenerated = false;
    public $isMatrixComplete = false;
    public $isMatrixSavedAndComplete = false;
    public $justGenerated = false;
    public $generationId = 0;

    public function mount() {
        $ahp = AhpPrinsip::first();
        if ($ahp) {
            $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $this->matrix[$row][$col] = $ahp->{$row.'_'.$col} !== null ? (float) $ahp->{$row.'_'.$col} : null;
                    if ($ahp->{"norm_{$row}_{$col}"} !== null) {
                        $this->norm[$row][$col] = (float) $ahp->{"norm_{$row}_{$col}"};
                        $this->matriks_penjumlahan[$row][$col] = (float) $ahp->{"matriks_penjumlahan_{$row}_{$col}"};
                    }
                }
                if ($ahp->{"bobot_{$row}"} !== null) {
                    $this->bobot[$row] = (float) $ahp->{"bobot_{$row}"};
                    $this->jumlah_baris[$row] = (float) $ahp->{"jumlah_baris_{$row}"};
                    $this->cv[$row] = (float) $ahp->{"cv_{$row}"};
                    $this->isGenerated = true;
                }
            }
            $this->calculateJumlah();
            $this->checkMatrixSavedAndComplete();
            if ($this->isGenerated) {
                $this->calculateNormJumlah();
            }
        }
    }

    public function updatedMatrix() {
        $this->calculateJumlah();
        $this->isMatrixSavedAndComplete = false;
    }

    public function checkMatrixComplete() {
        $complete = true;
        foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $row) {
            foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $col) {
                if ($this->matrix[$row][$col] === null || $this->matrix[$row][$col] === '') {
                    $complete = false;
                    break 2;
                }
            }
        }
        $this->isMatrixComplete = $complete;
    }

    public function checkMatrixSavedAndComplete() {
        $ahp = AhpPrinsip::first();
        if (!$ahp) {
            $this->isMatrixSavedAndComplete = false;
            return;
        }
        
        $complete = true;
        foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $row) {
            foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $col) {
                if ($ahp->{$row.'_'.$col} === null) {
                    $complete = false;
                    break 2;
                }
            }
        }
        $this->isMatrixSavedAndComplete = $complete && $this->isMatrixComplete;
    }

    public function calculateJumlah() {
        foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $col) {
            $sum = 0;
            foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $row) {
                $val = str_replace(',', '.', $this->matrix[$row][$col] ?? 0);
                $sum += is_numeric($val) ? (float) $val : 0;
            }
            $this->jumlah[$col] = round($sum, 4);
        }
        $this->checkMatrixComplete();
    }

    public function calculateNormJumlah() {
        $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];
        foreach ($cols as $col) {
            $sumCol = 0;
            foreach ($cols as $row) {
                $sumCol += $this->norm[$row][$col] ?? 0;
            }
            $this->norm_jumlah[$col] = $sumCol;
        }
    }

    public function generateMatrix() {
        if (!$this->isMatrixSavedAndComplete) return;

        // Simulasi proses kalkulasi yang berat agar spinner terlihat minimal 3 detik
        sleep(3);

        $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];

        // 1. Tabel 4.2 Normalisasi
        foreach ($cols as $row) {
            foreach ($cols as $col) {
                $val = (float) str_replace(',', '.', $this->matrix[$row][$col]);
                $sumCol = $this->jumlah[$col];
                $this->norm[$row][$col] = $sumCol != 0 ? $val / $sumCol : 0;
            }
        }
        $this->calculateNormJumlah();

        // 2. Tabel 4.3 Bobot Prioritas
        foreach ($cols as $row) {
            $sumRow = 0;
            foreach ($cols as $col) {
                $sumRow += $this->norm[$row][$col];
            }
            $this->bobot[$row] = $sumRow / 5;
        }

        // 3. Tabel 4.4 Matriks Penjumlahan
        foreach ($cols as $row) {
            $sumBaris = 0;
            foreach ($cols as $col) {
                $val = (float) str_replace(',', '.', $this->matrix[$row][$col]);
                $multiplied = $val * $this->bobot[$col];
                $this->matriks_penjumlahan[$row][$col] = $multiplied;
                $sumBaris += $multiplied;
            }
            $this->jumlah_baris[$row] = $sumBaris;
        }

        // 4. Tabel 4.5 Consistency Vector
        foreach ($cols as $row) {
            $this->cv[$row] = $this->bobot[$row] != 0 ? $this->jumlah_baris[$row] / $this->bobot[$row] : 0;
        }

        $this->isGenerated = true;
        $this->justGenerated = true;
        $this->generationId++;

        // Simpan hasil generate langsung ke DB
        $data = [];
        foreach ($cols as $row) {
            foreach ($cols as $col) {
                $data["norm_{$row}_{$col}"] = $this->norm[$row][$col] ?? null;
                $data["matriks_penjumlahan_{$row}_{$col}"] = $this->matriks_penjumlahan[$row][$col] ?? null;
            }
            $data["bobot_{$row}"] = $this->bobot[$row] ?? null;
            $data["jumlah_baris_{$row}"] = $this->jumlah_baris[$row] ?? null;
            $data["cv_{$row}"] = $this->cv[$row] ?? null;
        }

        $ahp = AhpPrinsip::first();
        if ($ahp) {
            $ahp->update($data);
        }
    }

    public function save() {
        $cols = ['p1', 'p2', 'p3', 'p4', 'p5'];
        $data = [];
        
        // Simpan input matriks 4.1
        foreach ($cols as $row) {
            foreach ($cols as $col) {
                $val = str_replace(',', '.', $this->matrix[$row][$col]);
                $data[$row.'_'.$col] = is_numeric($val) ? (float) $val : null;
            }
        }
        foreach ($cols as $col) {
            $data['jumlah_'.$col] = $this->jumlah[$col];
        }

        // Simpan hasil generate (jika ada)
        if ($this->isGenerated) {
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $data["norm_{$row}_{$col}"] = $this->norm[$row][$col] ?? null;
                    $data["matriks_penjumlahan_{$row}_{$col}"] = $this->matriks_penjumlahan[$row][$col] ?? null;
                }
                $data["bobot_{$row}"] = $this->bobot[$row] ?? null;
                $data["jumlah_baris_{$row}"] = $this->jumlah_baris[$row] ?? null;
                $data["cv_{$row}"] = $this->cv[$row] ?? null;
            }
        }

        $ahp = AhpPrinsip::first();
        if ($ahp) {
            $ahp->update($data);
        } else {
            AhpPrinsip::create($data);
        }

        return redirect(url('/admin/ahp/prinsip'))->with([
            'success' => [
                'title' => 'Data pembobotan prinsip berhasil disimpan.'
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.admin.ahp.prinsip-table');
    }
}
