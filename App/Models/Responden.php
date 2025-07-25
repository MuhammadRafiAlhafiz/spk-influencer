<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responden extends Model
{
    use HasFactory;

    protected $table = 'responden'; // ✅ Tambahkan ini agar Eloquent tahu nama tabel

    protected $fillable = [
        'kode_responden',
        'nama_responden',
        'email_responden',
        'platform_responden',
        'kategori_responden',
        'followers',
        'likes',
        'comments',
        'biaya_responden',
        'relevansi_responden',
    ];
}
