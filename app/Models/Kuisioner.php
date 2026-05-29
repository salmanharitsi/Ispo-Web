<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuisioner extends Model
{
    use HasFactory;

    protected $table = "kuisioner";
    protected $keyType = 'string';
    public $incrementing = false;
    
    protected $casts = [
        'p1_q1_surat_kepemilikan_sah' => 'float',
        'p1_q5_memiliki_stdb' => 'float',
    ];

    protected $fillable = [
        "user_id",
        "kebun_id",
        "p1_q1_surat_kepemilikan_sah",
        "p1_q2_di_luar_kawasan_terlarang",
        "p1_q3_bebas_sengketa",
        "p1_q4_batas_lahan_jelas", 
        "p1_q5_memiliki_stdb",
        "p1_q6_memiliki_izin_lingkungan",
        "p1_q7_catatan_pengelolaan_lingkungan",
        "p2_q8_tergabung_kelompok_tani",
        "p2_q9_kelompok_memiliki_dokumen_resmi",
        "p2_q10_rencana_kerja_tertulis",
        "p2_q11_catatan_kegiatan_kebun",
        "p2_q12_buka_lahan_tanpa_bakar",
        "p2_q13_bibit_dari_produsen_resmi",
        "p2_q14_catatan_asal_bibit",
        "p2_q15_tanam_sesuai_standar",
        "p2_q16_catatan_pelaksanaan_tanam",
        "p2_q17_bebas_lahan_gambut",
        "p2_q18_pemeliharaan_rutin",
        "p2_q19_catatan_pemupukan_pemeliharaan",
        "p2_q20_pengendalian_hama_sesuai_pht",
        "p2_q21_sarana_pengendalian_hama",
        "p2_q22_panen_buah_matang",
        "p2_q23_catatan_hasil_panen",
        "p2_q24_tbs_segera_diangkut",
        "p3_q25_upaya_mencegah_kebakaran",
        "p3_q26_memiliki_alat_pemadam",
        "p3_q27_mengetahui_satwa_tumbuhan",
        "p3_q28_mencatat_satwa_tumbuhan",
        "p4_q29_mendapat_info_resmi_harga",
        "p4_q30_catat_harga_dan_jumlah_tbs",
        "p4_q31_prosedur_pemberian_informasi",
        "p4_q32_pernah_menerima_info_resmi",
        "p5_q33_rencana_perbaikan_usaha",
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function kebun()
    {
        return $this->belongsTo(Kebun::class);
    }
}
