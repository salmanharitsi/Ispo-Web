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

    public function getSaranAttribute()
    {
        $saran = [];

        if ($this->p1_q1_surat_kepemilikan_sah == 0) $saran[] = "Segera urus surat kepemilikan lahan yang sah (sertifikat, akta jual beli, girik, atau dokumen kepemilikan lain).";
        elseif ($this->p1_q1_surat_kepemilikan_sah < 4) $saran[] = "Tingkatkan status surat kepemilikan lahan Anda menjadi SHM (Sertifikat Hak Milik).";

        if ($this->p1_q2_di_luar_kawasan_terlarang == 0) $saran[] = "Pastikan lokasi kebun Anda berada di luar kawasan hutan atau area yang dilarang tanam sesuai aturan yang berlaku.";
        if ($this->p1_q3_bebas_sengketa == 0) $saran[] = "Selesaikan sengketa lahan dengan pihak terkait agar lahan bebas dari sengketa.";
        if ($this->p1_q4_batas_lahan_jelas == 0) $saran[] = "Perjelas batas lahan Anda agar tidak tumpang tindih dengan lahan pihak lain.";
        
        if ($this->p1_q5_memiliki_stdb == 0.5) $saran[] = "Segerakan dan pastikan pengurusan kepemilikan STDB.";
        elseif ($this->p1_q5_memiliki_stdb == 0) $saran[] = "Segera urus dan miliki STDB (Surat Tanda Daftar Budidaya).";

        if ($this->p1_q6_memiliki_izin_lingkungan == 0) $saran[] = "Urus izin lingkungan sesuai regulasi SPPL (atau dokumen izin lingkungan lain).";
        if ($this->p1_q7_catatan_pengelolaan_lingkungan == 0) $saran[] = "Buat dan simpan catatan pengelolaan lingkungan sesuai izin (misalnya limbah, saluran air, pembatasan pembakaran).";

        if ($this->p2_q8_tergabung_kelompok_tani == 0) $saran[] = "Bergabunglah dengan kelompok tani atau koperasi pekebun terdekat.";
        if ($this->p2_q9_kelompok_memiliki_dokumen_resmi == 0) $saran[] = "Pastikan kelompok tani atau koperasi Anda memiliki dokumen resmi (pembentukan, daftar anggota, atau pengesahan).";
        if ($this->p2_q10_rencana_kerja_tertulis == 0) $saran[] = "Buatlah rencana kerja tertulis untuk rencana usaha kebun anda.";
        if ($this->p2_q11_catatan_kegiatan_kebun == 0) $saran[] = "Buatlah laporan kegiatan kebun atau catatan kegiatan rutin.";
        if ($this->p2_q12_buka_lahan_tanpa_bakar == 0) $saran[] = "Terapkan metode pembukaan lahan tanpa bakar (Zero Burning) untuk pembukaan lahan selanjutnya.";
        if ($this->p2_q13_bibit_dari_produsen_resmi == 0) $saran[] = "Gunakan bibit sawit yang berasal dari produsen resmi atau bersertifikat.";
        if ($this->p2_q14_catatan_asal_bibit == 0) $saran[] = "Buat dan simpan catatan asal bibit (asal benih, tanggal perolehan).";
        if ($this->p2_q15_tanam_sesuai_standar == 0) $saran[] = "Terapkan jarak tanam dan cara tanam yang sesuai standar tanam sawit.";
        if ($this->p2_q16_catatan_pelaksanaan_tanam == 0) $saran[] = "Catat pelaksanaan penanaman (tanggal tanam, jumlah bibit, luas lahan).";
        if ($this->p2_q17_bebas_lahan_gambut == 0) $saran[] = "Pastikan pengelolaan lahan di area gambut sesuai aturan gambut yang berlaku.";
        if ($this->p2_q18_pemeliharaan_rutin == 0) $saran[] = "Lakukan pemeliharaan tanaman secara rutin (pemupukan, pemangkasan pelepah, perawatan saluran air, dsb).";
        if ($this->p2_q19_catatan_pemupukan_pemeliharaan == 0) $saran[] = "Simpan catatan pemupukan dan kegiatan pemeliharaan tanaman secara rapi.";
        if ($this->p2_q20_pengendalian_hama_sesuai_pht == 0) $saran[] = "Terapkan pengendalian hama secara terencana sesuai pedoman PHT (misalnya rotasi, pestisida aman, pengamatan rutin).";
        if ($this->p2_q21_sarana_pengendalian_hama == 0) $saran[] = "Lengkapi alat atau sarana untuk pengendalian hama sesuai pedoman (semprot, pelindung, perangkap, dsb).";
        if ($this->p2_q22_panen_buah_matang == 0) $saran[] = "Pastikan memanen buah hanya ketika buah sudah matang panen.";
        if ($this->p2_q23_catatan_hasil_panen == 0) $saran[] = "Buatlah catatan hasil panen (jumlah tandan, tanggal panen).";
        if ($this->p2_q24_tbs_segera_diangkut == 0) $saran[] = "Pastikan TBS segera diangkut ke pembeli/pabrik tanpa penundaan yang lama setelah panen.";

        if ($this->p3_q25_upaya_mencegah_kebakaran == 0) $saran[] = "Lakukan upaya mencegah kebakaran kebun (misalnya membuat sekat api, patroli, gotong royong dengan warga).";
        if ($this->p3_q26_memiliki_alat_pemadam == 0) $saran[] = "Sediakan alat dasar pemadam kebakaran di kebun (misalnya pompa air, ember, atau alat semprot).";
        if ($this->p3_q27_mengetahui_satwa_tumbuhan == 0) $saran[] = "Kenali dan perhatikan keberadaan satwa atau tumbuhan liar di atau dekat kebun.";
        if ($this->p3_q28_mencatat_satwa_tumbuhan == 0) $saran[] = "Catat atau dokumentasikan keberadaan satwa/tumbuhan liar yang ada di sekitar kebun.";

        if ($this->p4_q29_mendapat_info_resmi_harga == 0) $saran[] = "Dapatkan informasi resmi harga TBS dari tim penetapan harga sebelum menjual.";
        if ($this->p4_q30_catat_harga_dan_jumlah_tbs == 0) $saran[] = "Catat harga dan jumlah TBS yang Anda jual.";
        if ($this->p4_q31_prosedur_pemberian_informasi == 0) $saran[] = "Buat prosedur atau aturan tertulis di kelompok tani/koperasi untuk memberikan informasi kepada anggota/petani.";
        if ($this->p4_q32_pernah_menerima_info_resmi == 0) $saran[] = "Pastikan Anda menerima informasi resmi tentang kebun/aturan/standar dari kelompok tani, koperasi, atau instansi terkait.";

        if ($this->p5_q33_rencana_perbaikan_usaha == 0) $saran[] = "Buatlah rencana perbaikan usaha kebun (misalnya perbaikan drainase, re-planting, perbaikan perawatan, perbaikan manajemen) untuk jangka panjang.";

        return $saran;
    }
}
