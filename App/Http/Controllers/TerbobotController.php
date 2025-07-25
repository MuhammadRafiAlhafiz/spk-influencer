<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class TerbobotController extends Controller
{
    public function index()
    {
        $influencers = Influencer::all();
        $kriterias = Kriteria::all();

        $maxEngagement = $influencers->max('engagement_alternatif');
        $maxBiaya = $influencers->max('biaya_alternatif');

        $bobotEngagement = $kriterias->where('nama_kriteria', 'Engagement Rate')->first()->bobot_kriteria ?? 0;
        $bobotBiaya = $kriterias->where('nama_kriteria', 'Biaya')->first()->bobot_kriteria ?? 0;
        $bobotRelevansi = $kriterias->where('nama_kriteria', 'Relevansi Konten')->first()->bobot_kriteria ?? 0;

        $dataTerbobot = [];

        foreach ($influencers as $influencer) {
            $relevansiAngka = $this->konversiRelevansi($influencer->relevansi_alternatif);

            $normalizedEngagement = $maxEngagement ? $influencer->engagement_alternatif / $maxEngagement : 0;
            $normalizedBiaya = $maxBiaya ? $influencer->biaya_alternatif / $maxBiaya : 0;
            $normalizedRelevansi = $relevansiAngka / 4;

            $dataTerbobot[] = [
                'kode_responden' => $influencer->kode_responden ?? '-',
                'nama' => $influencer->nama_alternatif,
                'engagement' => $normalizedEngagement * $bobotEngagement,
                'biaya_terbobot' => $normalizedBiaya * $bobotBiaya,
                'relevansi_terbobot' => $normalizedRelevansi * $bobotRelevansi,
            ];
        }

        return view('pages.terbobot', compact('dataTerbobot'));
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
