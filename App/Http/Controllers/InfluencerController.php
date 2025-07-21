<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influencer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InfluencerImport;

class InfluencerController extends Controller
{
    /**
     * Menampilkan halaman data alternatif (influencer)
     */
    public function index()
    {
        $influencers = Influencer::all();
        return view('pages.alternatif', compact('influencers'));
    }

    /**
     * Store data influencer (alternatif)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_alternatif' => 'required|string|max:255',
            'platform_alternatif' => 'required|string|max:100',
            'kategori_alternatif' => 'required|string|max:100',
            'followers' => 'required|integer|min:1',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'biaya_alternatif' => 'required|integer|min:0',
            'relevansi_alternatif' => 'required|string|in:Sangat Baik,Baik,Cukup,Kurang',
        ]);

        // Hitung engagement rate otomatis
        $total_engagement = $request->likes + $request->comments;
        $engagement_rate = ($total_engagement / $request->followers) * 100;

        Influencer::create([
            'nama_alternatif' => $request->nama_alternatif,
            'platform_alternatif' => $request->platform_alternatif,
            'kategori_alternatif' => $request->kategori_alternatif,
            'followers' => $request->followers,
            'likes' => $request->likes,
            'comments' => $request->comments,
            'engagement_alternatif' => $engagement_rate,
            'biaya_alternatif' => $request->biaya_alternatif,
            'relevansi_alternatif' => $request->relevansi_alternatif,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data influencer berhasil ditambahkan.');
    }

    /**
     * Update data influencer
     */

    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    Excel::import(new InfluencerImport, $request->file('file'));

    return back()->with('success', 'Data influencer berhasil diimport!');
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_alternatif' => 'required|string|max:255',
            'platform_alternatif' => 'required|string|max:100',
            'kategori_alternatif' => 'required|string|max:100',
            'followers' => 'required|integer|min:1',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'biaya_alternatif' => 'required|integer|min:0',
            'relevansi_alternatif' => 'required|string|in:Sangat Baik,Baik,Cukup,Kurang',
        ]);

        $influencer = Influencer::findOrFail($id);

        // Hitung engagement rate otomatis
        $total_engagement = $request->likes + $request->comments;
        $engagement_rate = ($total_engagement / $request->followers) * 100;

        $influencer->update([
            'nama_alternatif' => $request->nama_alternatif,
            'platform_alternatif' => $request->platform_alternatif,
            'kategori_alternatif' => $request->kategori_alternatif,
            'followers' => $request->followers,
            'likes' => $request->likes,
            'comments' => $request->comments,
            'engagement_alternatif' => $engagement_rate,
            'biaya_alternatif' => $request->biaya_alternatif,
            'relevansi_alternatif' => $request->relevansi_alternatif,
        ]);

        return redirect()->route('alternatif.index')->with('success', 'Data influencer berhasil diperbarui.');
    }

    /**
     * Delete data influencer
     */
    public function destroy($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->delete();

        return redirect()->route('alternatif.index')->with('success', 'Data influencer berhasil dihapus.');
    }
}
