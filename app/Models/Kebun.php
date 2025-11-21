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
        "tahun_tanam_pertama",
        "kondisi_tanah",
        "umur_tanaman",
        "jumlah_pohon",
        "polygon",
        "status_ispo",
    ];

    protected $casts = [
        'polygon' => 'array',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kuisioner()
    {
        return $this->hasOne(Kuisioner::class);
    }
}
