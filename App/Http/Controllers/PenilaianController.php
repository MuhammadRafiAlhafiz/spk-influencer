<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;

class PenilaianController extends Controller
{
    public function index()
    {
        $penilaians = Penilaian::with('influencer', 'kriteria')->get();
        return view('pages.nilai', compact('penilaians'));
    }
}
