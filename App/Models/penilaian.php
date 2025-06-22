<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaians';

    protected $fillable = [
        'influencer_id', 'kriteria_id', 'nilai_l', 'nilai_m', 'nilai_u'
    ];

    public $timestamps = false;

    public function influencer()
    {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'kriteria_id');
    }
}
