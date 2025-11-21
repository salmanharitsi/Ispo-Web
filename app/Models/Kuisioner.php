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
        "p1_dokumen_kepemilikan_sah",
        "p1_batas_lahan_jelas",
        "p1_di_luar_kawasan_hutan",
        "p1_memiliki_stdb", 
        "p1_tidak_dalam_sengketa",
        "p1_tahu_aturan_pemerintah",
        "p2_bibit_bersertifikat",
        "p2_catatan_pemupukan",
        "p2_pemupukan_sesuai_kebutuhan",
        "p2_panen_rutin",
        "p2_rawat_piringan_tpt",
        "p2_kendali_gulma_tanpa_bakar",
        "p2_pengendalian_hama_sesuai_anjuran",
        "p2_pestisida_sesuai_label",
        "p2_catatan_produksi_tbs",
        "p2_tahu_standar_mutu_tbs",
        "p3_memiliki_sppl",
        "p3_kelola_limbah_kebun_benar",
        "p3_hindari_bakar_lahan",
        "p3_jaga_sumber_air",
        "p3_hindari_pestisida_terlarang",
        "p3_area_konservasi_kecil",
        "p4_tergabung_kelompok_tani",
        "p4_kelompok_aktif_pembinaan",
        "p4_pelatihan_budidaya_sawit",
        "p4_pelatihan_ispo",
        "p4_tahu_manfaat_ispo",
        "p4_catat_biaya_usaha",
        "p4_catat_pendapatan_tbs",
        "p5_pendapatan_cukup",
        "p5_siap_sertifikasi_ispo",
        "p5_kesulitan_biaya_pemeliharaan",
        "p5_butuh_dukungan_pembiayaan",
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
