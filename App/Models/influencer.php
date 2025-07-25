<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;
    protected $table = 'influencers';

    protected $fillable = [
        'kode_responden',
        'nama_alternatif',
        'platform_alternatif',
        'kategori_alternatif',
        'followers',
        'likes',
        'comments',
        'biaya_alternatif',
        'relevansi_alternatif',
        'engagement_alternatif',
    ];
}
