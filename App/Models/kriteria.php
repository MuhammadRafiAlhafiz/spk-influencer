<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'kriterias';

        protected $fillable = ['kode_kriteria', 'nama_kriteria', 'bobot_kriteria'];


    public $timestamps = false;
}
