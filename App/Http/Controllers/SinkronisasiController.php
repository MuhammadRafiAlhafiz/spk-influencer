<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\Influencer;
use App\Models\Normalisasi;
use App\Models\Terbobot;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SinkronisasiController extends Controller
{
    public function sinkronisasi()
    {
        $respondenList = Responden::all();
        $count = 0;

        $kriteriaEngagement = Kriteria::where('nama_kriteria', 'Engagement Rate')->first()->bobot_kriteria ?? 0;
        $kriteriaBiaya = Kriteria::where('nama_kriteria', 'Biaya')->first()->bobot_kriteria ?? 0;
        $kriteriaRelevansi = Kriteria::where('nama_kriteria', 'Relevansi Konten')->first()->bobot_kriteria ?? 0;

        $maxEngagement = Responden::all()->map(function ($item) {
            return ($item->likes + $item->comments) / max($item->followers, 1) * 100;
        })->max();

        $maxBiaya = Responden::max('biaya_responden');

        foreach ($respondenList as $responden) {

            $engagement = ($responden->likes + $responden->comments) / max($responden->followers, 1) * 100;
            $normalizedEngagement = $maxEngagement ? $engagement / $maxEngagement : 0;
            $normalizedBiaya = $maxBiaya ? $responden->biaya_responden / $maxBiaya : 0;
            $relevansi = match(strtolower($responden->relevansi_responden)) {
                'sangat baik' => 4,
                'baik' => 3,
                'cukup' => 2,
                'kurang' => 1,
                default => 0,
            };
            $normalizedRelevansi = $relevansi / 4;

            // Insert ke Alternatif
            $influencer = Influencer::updateOrCreate(
    ['kode_responden' => $responden->kode_responden],
    [
        'kode_responden' => $responden->kode_responden,
        'nama_alternatif' => $responden->nama_responden,
        'platform_alternatif' => $responden->platform_responden,
        'kategori_alternatif' => $responden->kategori_responden,
        'biaya_alternatif' => $responden->biaya_responden,
        'relevansi_alternatif' => $responden->relevansi_responden,
        'engagement_alternatif' => ($responden->likes + $responden->comments) / max($responden->followers, 1) * 100,
    ]
);


            // Insert ke Normalisasi
            Normalisasi::updateOrCreate(
                ['alternatif_id' => $influencer->id],
                [
                    'kode_responden' => $responden->kode_responden,
                    'alternatif_id' => $influencer->id,
                    'engagement_normalisasi' => $normalizedEngagement,
                    'biaya_normalisasi' => $normalizedBiaya,
                    'relevansi_normalisasi' => $normalizedRelevansi,
                ]
            );

            // Insert ke Terbobot
            Terbobot::updateOrCreate(
                ['alternatif_id' => $influencer->id],
                [
                    'kode_responden' => $responden->kode_responden,
                    'alternatif_id' => $influencer->id,
                    'engagement_terbobot' => $normalizedEngagement * $kriteriaEngagement,
                    'biaya_terbobot' => $normalizedBiaya * $kriteriaBiaya,
                    'relevansi_terbobot' => $normalizedRelevansi * $kriteriaRelevansi,
                ]
            );

            $count++;
        }

        return back()->with('success', "$count data berhasil disinkronkan ke Alternatif, Normalisasi, dan Terbobot.");
    }
}
