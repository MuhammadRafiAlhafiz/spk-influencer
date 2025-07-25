<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class FuzzyTopsisController extends Controller
{
    public function index()
    {
        $alternatifs = Influencer::all();
        $kriterias = Kriteria::all();

        // Ambil bobot
        $bobot = [];
        foreach ($kriterias as $kriteria) {
            $bobot[strtolower($kriteria->nama_kriteria)] = $kriteria->bobot_kriteria;
        }

        // Max dan Min untuk normalisasi
        $maxEngagement = $alternatifs->max('engagement_alternatif');
        $minBiaya = $alternatifs->min('biaya_alternatif');
        $maxRelevansi = 4; // relevansi sudah dikonversi ke 1-4

        // Normalisasi dan terbobot
        $data = [];
        foreach ($alternatifs as $alt) {
            $relevansi = match(strtolower($alt->relevansi_alternatif)) {
                'sangat baik' => 4,
                'baik' => 3,
                'cukup' => 2,
                'kurang' => 1,
                default => 0,
            };

            $normEngagement = $maxEngagement ? $alt->engagement_alternatif / $maxEngagement : 0;
            $normBiaya = $minBiaya ? $minBiaya / $alt->biaya_alternatif : 0;
            $normRelevansi = $relevansi / $maxRelevansi;

            $terbobotEngagement = $normEngagement * ($bobot['engagement rate'] ?? 0);
            $terbobotBiaya = $normBiaya * ($bobot['biaya'] ?? 0);
            $terbobotRelevansi = $normRelevansi * ($bobot['relevansi konten'] ?? 0);

            $data[] = [
                'kode_responden' => $alt->kode_responden,
                'nama' => $alt->nama_alternatif,
                'platform' => $alt->platform_alternatif,
                'kategori' => $alt->kategori_alternatif,
                'terbobot_engagement' => $terbobotEngagement,
                'terbobot_biaya' => $terbobotBiaya,
                'terbobot_relevansi' => $terbobotRelevansi,
            ];
        }

        // Hitung A+ dan A-
        $A_plus = [
            'terbobot_engagement' => collect($data)->max('terbobot_engagement'),
            'terbobot_biaya' => collect($data)->max('terbobot_biaya'),
            'terbobot_relevansi' => collect($data)->max('terbobot_relevansi'),
        ];

        $A_min = [
            'terbobot_engagement' => collect($data)->min('terbobot_engagement'),
            'terbobot_biaya' => collect($data)->min('terbobot_biaya'),
            'terbobot_relevansi' => collect($data)->min('terbobot_relevansi'),
        ];

        // Hitung D+ dan D-, dan V_i
        $hasil = [];
        foreach ($data as $item) {
            $D_plus = sqrt(
                pow($item['terbobot_engagement'] - $A_plus['terbobot_engagement'], 2) +
                pow($item['terbobot_biaya'] - $A_plus['terbobot_biaya'], 2) +
                pow($item['terbobot_relevansi'] - $A_plus['terbobot_relevansi'], 2)
            );

            $D_min = sqrt(
                pow($item['terbobot_engagement'] - $A_min['terbobot_engagement'], 2) +
                pow($item['terbobot_biaya'] - $A_min['terbobot_biaya'], 2) +
                pow($item['terbobot_relevansi'] - $A_min['terbobot_relevansi'], 2)
            );

            $V = ($D_plus + $D_min) > 0 ? $D_min / ($D_plus + $D_min) : 0;

            $hasil[] = [
                'kode_responden' => $item['kode_responden'],
                'nama' => $item['nama'],
                'platform' => $item['platform'],
                'kategori' => $item['kategori'],
                'V' => $V,
            ];
        }

        // Sorting ranking
        $hasil = collect($hasil)->sortByDesc('V')->values()->all();

        return view('pages.perhitungan', compact('hasil'));
    }
}
