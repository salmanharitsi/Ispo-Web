<?php

namespace App\Livewire\Admin\Ahp;

use Livewire\Component;
use App\Models\AhpKriteria;

class KriteriaManager extends Component
{
    public $activeTab = 'p1';

    public $prinsipData = [
        'p1' => [
            'name' => 'Prinsip 1',
            'criteria' => [
                'k1' => 'K1.1 - Legalitas lahan',
                'k2' => 'K1.2 - Lokasi kebun sesuai aturan',
                'k3' => 'K1.3 - Sengketa lahan & penyelesaian',
                'k4' => 'K1.4 - Legalitas usaha perkebunan',
                'k5' => 'K1.5 - Izin lingkungan & kepatuhan lingkungan'
            ]
        ],
        'p2' => [
            'name' => 'Prinsip 2',
            'criteria' => [
                'k1' => 'K2.1 - Kelembagaan pekebun',
                'k2' => 'K2.2 - Manajemen usaha / kelompok',
                'k3' => 'K2.3 - Teknis budidaya & produksi'
            ]
        ],
        'p3' => [
            'name' => 'Prinsip 3',
            'criteria' => [
                'k1' => 'K3.1 - Pencegahan & penanggulangan kebakaran',
                'k2' => 'K3.2 - Pelestarian Keanekaragaman Hayati'
            ]
        ],
        'p4' => [
            'name' => 'Prinsip 4',
            'criteria' => [
                'k1' => 'K4.1 - Harga & penjualan TBS',
                'k2' => 'K4.2 - Penyediaan data & informasi usaha'
            ]
        ],
        'p5' => [
            'name' => 'Prinsip 5',
            'criteria' => [
                'k1' => 'K5.1 - Perbaikan usaha secara berkelanjutan'
            ]
        ],
    ];

    public $matrix = [];
    public $jumlah = [];
    public $norm = [];
    public $bobot = [];
    public $matriks_penjumlahan = [];
    public $jumlah_baris = [];
    public $cv = [];
    public $norm_jumlah = [];

    public $isGenerated = false;
    public $isMatrixComplete = false;
    public $isMatrixSavedAndComplete = false;
    public $justGenerated = false;
    public $generationId = 0;

    public $completedTabs = [];

    public function mount() {
        $this->loadCompletedTabs();
        $this->loadTabData($this->activeTab);
    }

    public function switchTab($tab) {
        $this->activeTab = $tab;
        $this->justGenerated = false;
        $this->loadTabData($tab);
    }

    public function loadCompletedTabs() {
        $completed = [];
        $records = AhpKriteria::all();
        foreach ($records as $record) {
            $p = $record->prinsip_code;
            if (isset($this->prinsipData[$p])) {
                $cols = array_keys($this->prinsipData[$p]['criteria']);
                $isComplete = true;
                foreach ($cols as $r) {
                    foreach ($cols as $c) {
                        if ($record->{$r.'_'.$c} === null) {
                            $isComplete = false;
                            break 2;
                        }
                    }
                }
                if ($isComplete) {
                    $completed[] = $p;
                }
            }
        }
        $this->completedTabs = $completed;
    }

    public function loadTabData($tab) {
        $cols = array_keys($this->prinsipData[$tab]['criteria']);
        
        $this->matrix = [];
        $this->jumlah = [];
        $this->norm = [];
        $this->bobot = [];
        $this->matriks_penjumlahan = [];
        $this->jumlah_baris = [];
        $this->cv = [];
        $this->norm_jumlah = [];
        $this->isGenerated = false;
        $this->isMatrixComplete = false;
        $this->isMatrixSavedAndComplete = false;

        foreach ($cols as $c) {
            $this->jumlah[$c] = 0;
            $this->norm_jumlah[$c] = 0;
            foreach ($cols as $r) {
                $this->matrix[$r][$c] = null;
            }
        }

        $record = AhpKriteria::where('prinsip_code', $tab)->first();
        if ($record) {
            foreach ($cols as $row) {
                foreach ($cols as $col) {
                    $this->matrix[$row][$col] = $record->{$row.'_'.$col} !== null ? (float) $record->{$row.'_'.$col} : null;
                    if ($record->{"norm_{$row}_{$col}"} !== null) {
                        $this->norm[$row][$col] = (float) $record->{"norm_{$row}_{$col}"};
                        $this->matriks_penjumlahan[$row][$col] = (float) $record->{"matriks_penjumlahan_{$row}_{$col}"};
                    }
                }
                if ($record->{"bobot_{$row}"} !== null) {
                    $this->bobot[$row] = (float) $record->{"bobot_{$row}"};
                    $this->jumlah_baris[$row] = (float) $record->{"jumlah_baris_{$row}"};
                    $this->cv[$row] = (float) $record->{"cv_{$row}"};
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
        $cols = array_keys($this->prinsipData[$this->activeTab]['criteria']);
        $complete = true;
        foreach ($cols as $row) {
            foreach ($cols as $col) {
                if (!isset($this->matrix[$row][$col]) || $this->matrix[$row][$col] === null || $this->matrix[$row][$col] === '') {
                    $complete = false;
                    break 2;
                }
            }
        }
        $this->isMatrixComplete = $complete;
    }

    public function checkMatrixSavedAndComplete() {
        $record = AhpKriteria::where('prinsip_code', $this->activeTab)->first();
        if (!$record) {
            $this->isMatrixSavedAndComplete = false;
            return;
        }
        
        $cols = array_keys($this->prinsipData[$this->activeTab]['criteria']);
        $complete = true;
        foreach ($cols as $row) {
            foreach ($cols as $col) {
                if ($record->{$row.'_'.$col} === null) {
                    $complete = false;
                    break 2;
                }
            }
        }
        $this->isMatrixSavedAndComplete = $complete && $this->isMatrixComplete;
    }

    public function calculateJumlah() {
        $cols = array_keys($this->prinsipData[$this->activeTab]['criteria']);
        foreach ($cols as $col) {
            $sum = 0;
            foreach ($cols as $row) {
                $val = str_replace(',', '.', $this->matrix[$row][$col] ?? 0);
                $sum += is_numeric($val) ? (float) $val : 0;
            }
            $this->jumlah[$col] = round($sum, 4);
        }
        $this->checkMatrixComplete();
    }

    public function calculateNormJumlah() {
        $cols = array_keys($this->prinsipData[$this->activeTab]['criteria']);
        foreach ($cols as $col) {
            $sumCol = 0;
            foreach ($cols as $row) {
                $sumCol += $this->norm[$row][$col] ?? 0;
            }
            $this->norm_jumlah[$col] = $sumCol;
        }
    }

    public function save() {
        $cols = array_keys($this->prinsipData[$this->activeTab]['criteria']);
        $data = ['prinsip_code' => $this->activeTab];
        
        foreach ($cols as $row) {
            foreach ($cols as $col) {
                $val = str_replace(',', '.', $this->matrix[$row][$col]);
                $data[$row.'_'.$col] = is_numeric($val) ? (float) $val : null;
            }
        }
        foreach ($cols as $col) {
            $data['jumlah_'.$col] = $this->jumlah[$col];
        }

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

        $record = AhpKriteria::where('prinsip_code', $this->activeTab)->first();
        if ($record) {
            $record->update($data);
        } else {
            AhpKriteria::create($data);
        }

        $this->loadCompletedTabs();
        $this->checkMatrixSavedAndComplete();

        return redirect(url('/admin/ahp/kriteria'))->with([
            'success' => [
                'title' => 'Data kriteria untuk ' . $this->prinsipData[$this->activeTab]['name'] . ' berhasil disimpan.'
            ]
        ]);
    }

    public function generateMatrix() {
        if (!$this->isMatrixSavedAndComplete) return;

        sleep(3);

        $cols = array_keys($this->prinsipData[$this->activeTab]['criteria']);
        $n = count($cols);

        foreach ($cols as $row) {
            foreach ($cols as $col) {
                $val = (float) str_replace(',', '.', $this->matrix[$row][$col]);
                $sumCol = $this->jumlah[$col];
                $this->norm[$row][$col] = $sumCol != 0 ? $val / $sumCol : 0;
            }
        }
        $this->calculateNormJumlah();

        foreach ($cols as $row) {
            $sumRow = 0;
            foreach ($cols as $col) {
                $sumRow += $this->norm[$row][$col];
            }
            $this->bobot[$row] = $sumRow / $n;
        }

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

        foreach ($cols as $row) {
            $this->cv[$row] = $this->bobot[$row] != 0 ? $this->jumlah_baris[$row] / $this->bobot[$row] : 0;
        }

        $this->isGenerated = true;
        $this->justGenerated = true;
        $this->generationId++;

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

        $record = AhpKriteria::where('prinsip_code', $this->activeTab)->first();
        if ($record) {
            $record->update($data);
        }
        $this->loadCompletedTabs();
    }

    public function render()
    {
        return view('livewire.admin.ahp.kriteria-manager');
    }
}
