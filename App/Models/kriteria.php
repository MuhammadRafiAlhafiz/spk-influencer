<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriteria';

    protected $fillable = [
        'id', 'nama', 'bobot_l', 'bobot_m', 'bobot_u'
    ];

    public $timestamps = false;
}
