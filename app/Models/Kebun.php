<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kebun extends Model
{
    use HasFactory;

    protected $table = "kebun";
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        "user_id",
        "nama_kebun",
        "lokasi_kebun",
        "luas_lahan",
        "desa",
        "kecamatan",
        "tahun_tanam",
        "jumlah_pohon",
        "polygon",
        "polygon_sides",
        "centroid",
        "area_m2",
        "area_hectare",
        "perimeter_m",
        "latitude",
        "longitude",
        "status_ispo",
        "status_finalisasi",
        "catatan_pengecekan",
        "jenis_tanah",
        "asal_lahan",
        "status_lahan",
        "dokumen_kepemilikan_lahan",
        "jenis_bibit",
        "frekuensi_panen",
        "kepada_siapa_hasil_panen_dijual",
        "harga_jual_tbs_terakhir",
        "pendapatan_bersih",
    ];

    protected $casts = [
        'polygon' => 'array',
        'polygon_sides' => 'array',
        'centroid' => 'array',
        'luas_lahan' => 'decimal:2',
        'area_m2' => 'decimal:2',
        'area_hectare' => 'decimal:4',
        'perimeter_m' => 'decimal:2',
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

    // Accessor untuk mendapatkan centroid sebagai array [lat, lng]
    public function getCentroidAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (isset($decoded['lat']) && isset($decoded['lng'])) {
                return [$decoded['lat'], $decoded['lng']];
            }
        } elseif (is_array($value)) {
            if (isset($value['lat']) && isset($value['lng'])) {
                return [$value['lat'], $value['lng']];
            }
        }
        return null;
    }

    // Mutator untuk menyimpan centroid
    public function setCentroidAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['centroid'] = json_encode($value);
        } else {
            $this->attributes['centroid'] = $value;
        }
    }

    // Helper method untuk mendapatkan sisi berdasarkan orientasi
    public function getSidesByDirection($direction = null)
    {
        if (!$this->polygon_sides) {
            return [];
        }

        if ($direction === null) {
            return $this->polygon_sides;
        }

        return array_filter($this->polygon_sides, function($side) use ($direction) {
            return $side['direction'] === strtoupper($direction);
        });
    }

    // Helper method untuk mendapatkan total panjang sisi per arah
    public function getTotalLengthByDirection($direction)
    {
        $sides = $this->getSidesByDirection($direction);
        return array_sum(array_column($sides, 'distance'));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kuisioner()
    {
        return $this->hasOne(Kuisioner::class);
    }
}
