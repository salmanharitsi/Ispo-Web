<?php

namespace App\Livewire\Admin\Ahp;

use Livewire\Component;

class FinalTable extends Component
{
    public $prinsipGenerated = false;
    public $kriteriaGeneratedCount = 0;
    public $kriteriaGenerated = false;
    public $canGenerate = false;
    public $isGenerated = false;

    public $questions = [
        'q1' => ['text' => 'Dokumen kepemilikan lahan (SHM/AJB/SKGR...)', 'p' => 'p1', 'k' => 'k1', 'n' => 1],
        'q2' => ['text' => 'Kebun di luar kawasan hutan/terlarang?', 'p' => 'p1', 'k' => 'k2', 'n' => 1],
        'q3' => ['text' => 'Lahan bebas sengketa?', 'p' => 'p1', 'k' => 'k3', 'n' => 2],
        'q4' => ['text' => 'Batas lahan jelas/tidak tumpang tindih?', 'p' => 'p1', 'k' => 'k3', 'n' => 2],
        'q5' => ['text' => 'Status STDB (Sudah=1 / Proses=0.5 / Belum=0)', 'p' => 'p1', 'k' => 'k4', 'n' => 1],
        'q6' => ['text' => 'Punya izin lingkungan SPPL?', 'p' => 'p1', 'k' => 'k5', 'n' => 2],
        'q7' => ['text' => 'Ada catatan pengelolaan lingkungan?', 'p' => 'p1', 'k' => 'k5', 'n' => 2],
        
        'q8' => ['text' => 'Bergabung kelompok tani/koperasi?', 'p' => 'p2', 'k' => 'k1', 'n' => 2],
        'q9' => ['text' => 'Kelompok tani punya dok resmi?', 'p' => 'p2', 'k' => 'k1', 'n' => 2],
        'q10' => ['text' => 'Ada rencana kerja tertulis?', 'p' => 'p2', 'k' => 'k2', 'n' => 2],
        'q11' => ['text' => 'Ada laporan kegiatan/catatan rutin?', 'p' => 'p2', 'k' => 'k2', 'n' => 2],
        'q12' => ['text' => 'Buka lahan tanpa membakar?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q13' => ['text' => 'Bibit dari produsen bersertifikat?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q14' => ['text' => 'Ada catatan asal bibit?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q15' => ['text' => 'Tanam sesuai jarak standar sawit?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q16' => ['text' => 'Ada catatan pelaksanaan penanaman?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q17' => ['text' => 'Bebas/kelola sesuai aturan gambut?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q18' => ['text' => 'Pemeliharaan rutin (pupuk, pangkas, saluran)?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q19' => ['text' => 'Ada catatan pemupukan & pemeliharaan?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q20' => ['text' => 'Pengendalian hama sesuai PHT?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q21' => ['text' => 'Punya alat pengendalian hama?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q22' => ['text' => 'Panen hanya buah matang?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q23' => ['text' => 'Ada catatan hasil panen?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        'q24' => ['text' => 'TBS segera diangkut setelah panen?', 'p' => 'p2', 'k' => 'k3', 'n' => 13],
        
        'q25' => ['text' => 'Ikut upaya pencegahan kebakaran kebun?', 'p' => 'p3', 'k' => 'k1', 'n' => 2],
        'q26' => ['text' => 'Punya alat dasar pemadam kebakaran?', 'p' => 'p3', 'k' => 'k1', 'n' => 2],
        'q27' => ['text' => 'Mengetahui adanya satwa/tumbuhan liar?', 'p' => 'p3', 'k' => 'k2', 'n' => 2],
        'q28' => ['text' => 'Pernah dokumentasikan satwa/tumbuhan?', 'p' => 'p3', 'k' => 'k2', 'n' => 2],
        
        'q29' => ['text' => 'Dapat info resmi harga TBS sebelum jual?', 'p' => 'p4', 'k' => 'k1', 'n' => 2],
        'q30' => ['text' => 'Mencatat harga dan jumlah TBS dijual?', 'p' => 'p4', 'k' => 'k1', 'n' => 2],
        'q31' => ['text' => 'Kelompok tani punya prosedur info tertulis?', 'p' => 'p4', 'k' => 'k2', 'n' => 2],
        'q32' => ['text' => 'Pernah terima info resmi kebun/standar?', 'p' => 'p4', 'k' => 'k2', 'n' => 2],
        
        'q33' => ['text' => 'Punya rencana/sudah lakukan perbaikan jangka panjang?', 'p' => 'p5', 'k' => 'k1', 'n' => 1],
    ];

    public $prinsipBobots = [];
    public $kriteriaBobots = [];
    public $finalBobots = [];

    public function mount()
    {
        $this->checkPrerequisites();
        $this->loadExistingData();
    }

    public function checkPrerequisites()
    {
        $ahpPrinsip = \App\Models\AhpPrinsip::first();
        if ($ahpPrinsip && $ahpPrinsip->bobot_p1 !== null) {
            $this->prinsipGenerated = true;
            foreach (['p1', 'p2', 'p3', 'p4', 'p5'] as $p) {
                $this->prinsipBobots[$p] = (float) $ahpPrinsip->{"bobot_{$p}"};
            }
        }

        $ahpKriterias = \App\Models\AhpKriteria::whereIn('prinsip_code', ['p1', 'p2', 'p3', 'p4', 'p5'])->get();
        $this->kriteriaGeneratedCount = 0;
        foreach ($ahpKriterias as $k) {
            if ($k->bobot_k1 !== null) {
                $this->kriteriaGeneratedCount++;
                $cols = [];
                if ($k->prinsip_code == 'p1') $cols = ['k1', 'k2', 'k3', 'k4', 'k5'];
                if ($k->prinsip_code == 'p2') $cols = ['k1', 'k2', 'k3'];
                if ($k->prinsip_code == 'p3') $cols = ['k1', 'k2'];
                if ($k->prinsip_code == 'p4') $cols = ['k1', 'k2'];
                if ($k->prinsip_code == 'p5') $cols = ['k1'];
                
                foreach ($cols as $c) {
                    $this->kriteriaBobots[$k->prinsip_code][$c] = (float) $k->{"bobot_{$c}"};
                }
            }
        }
        
        $this->kriteriaGenerated = ($this->kriteriaGeneratedCount === 5);
        $this->canGenerate = $this->prinsipGenerated && $this->kriteriaGenerated;
    }

    public function loadExistingData()
    {
        $final = \App\Models\AhpFinal::first();
        if ($final && $final->q1 !== null) {
            $this->isGenerated = true;
            for ($i = 1; $i <= 33; $i++) {
                $this->finalBobots['q' . $i] = (float) $final->{'q' . $i};
            }
        }
    }

    public function generateFinalWeights()
    {
        if (!$this->canGenerate) return;

        $data = [];
        foreach ($this->questions as $id => $q) {
            $w_p = $this->prinsipBobots[$q['p']] ?? 0;
            $w_k = $this->kriteriaBobots[$q['p']][$q['k']] ?? 0;
            
            // Bobot soal = w_prinsip * w_kriteria / n_soal_dalam_kriteria
            $bobot = ($w_p * $w_k) / $q['n'];
            
            $this->finalBobots[$id] = $bobot;
            $data[$id] = $bobot;
        }

        $final = \App\Models\AhpFinal::first();
        if ($final) {
            $final->update($data);
        } else {
            \App\Models\AhpFinal::create($data);
        }

        $this->isGenerated = true;

        return redirect(url('/admin/ahp/final'))->with([
            'success' => [
                'title' => 'Pembobotan final berhasil digenerate dan disimpan.'
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.admin.ahp.final-table');
    }
}
