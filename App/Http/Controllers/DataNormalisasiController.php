<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class DataNormalisasiController extends Controller
{
    public function index()
    {
        $influencers = Influencer::all();
        $kriterias = Kriteria::all();

        $maxEngagement = $influencers->max('engagement_alternatif');
        $minBiaya = $influencers->min('biaya_alternatif'); // ✔️ Correct as Cost Criteria
        $relevansiMapping = [
            'sangat baik' => 4,
            'baik' => 3,
            'cukup' => 2,
            'kurang' => 1,
        ];

        $maxRelevansi = 4; // maksimum skala

        $dataNormalisasi = [];

        foreach ($influencers as $influencer) {
            $relevansiText = strtolower($influencer->relevansi_alternatif);
            $relevansiValue = $relevansiMapping[$relevansiText] ?? 0;

            $normalisasi = [
                'kode_responden' => $influencer->kode_responden ?? '-',
                'nama' => $influencer->nama_alternatif,
                'engagement' => $maxEngagement ? $influencer->engagement_alternatif / $maxEngagement : 0,
                'biaya' => $influencer->biaya_alternatif ? $minBiaya / $influencer->biaya_alternatif : 0, // ✔️ Correct Cost Criterion
                'relevansi' => $maxRelevansi ? $relevansiValue / $maxRelevansi : 0,
            ];

            $dataNormalisasi[] = $normalisasi;
        }

        return view('pages.normalisasi', compact('dataNormalisasi'));
    }
}
