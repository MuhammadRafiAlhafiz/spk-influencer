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
        $maxBiaya = $influencers->max('biaya_alternatif');

        $dataNormalisasi = [];
        $dataTerbobot = [];

        foreach ($influencers as $influencer) {
            $relevansiAngka = $this->konversiRelevansi($influencer->relevansi_alternatif);

            // Normalisasi
            $norm = [
                'nama' => $influencer->nama_alternatif,
                'engagement' => $maxEngagement ? $influencer->engagement_alternatif / $maxEngagement : 0,
                'biaya' => $maxBiaya ? $influencer->biaya_alternatif / $maxBiaya : 0,
                'relevansi' => $relevansiAngka / 4, // skala 1-4
            ];

            // Terbobot
            $bobotEngagement = $kriterias->where('nama_kriteria', 'Engagement Rate')->first()->bobot_kriteria ?? 0;
            $bobotBiaya = $kriterias->where('nama_kriteria', 'Biaya')->first()->bobot_kriteria ?? 0;
            $bobotRelevansi = $kriterias->where('nama_kriteria', 'Relevansi Konten')->first()->bobot_kriteria ?? 0;

            $ter = [
                'nama' => $influencer->nama_alternatif,
                'engagement' => $norm['engagement'] * $bobotEngagement,
                'biaya' => $norm['biaya'] * $bobotBiaya,
                'relevansi' => $norm['relevansi'] * $bobotRelevansi,
            ];

            $dataNormalisasi[] = $norm;
            $dataTerbobot[] = $ter;
        }

        return view('pages.normalisasi', compact('dataNormalisasi', 'dataTerbobot'));
    }

    private function konversiRelevansi($text)
    {
        return match(strtolower($text)) {
            'sangat baik' => 4,
            'baik' => 3,
            'cukup' => 2,
            'kurang' => 1,
            default => 0,
        };
    }
}
