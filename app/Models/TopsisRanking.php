<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopsisRanking extends Model
{
    //
    protected $guarded = [];

    public function kebun()
    {
        return $this->belongsTo(Kebun::class);
    }
}