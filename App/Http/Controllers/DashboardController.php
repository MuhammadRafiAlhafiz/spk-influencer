<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\Influencer;
use App\Models\Kriteria;
use App\Models\Normalisasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalResponden = Responden::count();
        $totalAlternatif = Influencer::count();
        $totalKriteria = Kriteria::count();
        $totalNormalisasi = Normalisasi::count();

        return view('pages.dashboard', compact(
            'totalResponden',
            'totalAlternatif',
            'totalKriteria',
            'totalNormalisasi'
        ));
    }
}
