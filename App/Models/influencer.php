<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    use HasFactory;

    protected $fillable = ['nama_alternatif', 'platform_alternatif', 'kategori_alternatif', 'engagement_alternatif', 'biaya_alternatif', 'relevansi_alternatif'];
}
