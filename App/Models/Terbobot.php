<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terbobot extends Model
{
    use HasFactory;

    protected $table = 'terbobots';

    protected $fillable = [
        'kode_responden',
        'alternatif_id',
        'engagement_terbobot',
        'biaya_terbobot',
        'relevansi_terbobot',
    ];
}
