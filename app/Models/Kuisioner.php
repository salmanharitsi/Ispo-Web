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

    protected $fillable = [
        "user_id",
        "kebun_id",
        "p1_q1_surat_kepemilikan_sah",
        "p1_q2_di_luar_kawasan_terlarang",
        "p1_q3_dokumen_penyelesaian_sengketa",
        "p1_q4_salinan_perjanjian_sengketa", 
        "p1_q5_memiliki_stdb",
        "p1_q6_sedang_mengurus_stdb",
        "p1_q7_memiliki_izin_lingkungan",
        "p1_q8_catatan_pengelolaan_lingkungan",
        "p2_q9_tergabung_kelompok_tani",
        "p2_q10_kelompok_memiliki_dokumen_resmi",
        "p2_q11_rencana_kerja_tertulis",
        "p2_q12_catatan_kegiatan_kebun",
        "p2_q13_buka_lahan_tanpa_bakar",
        "p2_q14_bibit_dari_produsen_resmi",
        "p2_q15_catatan_asal_bibit",
        "p2_q16_tanam_sesuai_standar",
        "p2_q17_catatan_pelaksanaan_tanam",
        "p2_q18_panduan_lahan_gambut",
        "p2_q19_pemeliharaan_rutin",
        "p2_q20_catatan_pemupukan_pemeliharaan",
        "p2_q21_pengendalian_hama_sesuai_pht",
        "p2_q22_sarana_pengendalian_hama",
        "p2_q23_panen_buah_matang",
        "p2_q24_catatan_hasil_panen",
        "p2_q25_tbs_segera_diangkut",
        "p3_q26_upaya_mencegah_kebakaran",
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
