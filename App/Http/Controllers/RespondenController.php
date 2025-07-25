<?php

namespace App\Http\Controllers;

use App\Models\Responden;
use App\Models\Influencer;
use App\Models\Normalisasi;
use App\Models\Tebobot;
use Illuminate\Http\Request;

class RespondenController extends Controller
{
    public function index()
    {
        $responden = Responden::latest()->get();
        return view('pages.responden', compact('responden'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'kode_responden' => 'required|string|unique:responden,kode_responden',
            'nama_responden' => 'required|string|max:255',
            'email_responden' => 'required|email|max:255',
            'platform_responden' => 'required|string',
            'kategori_responden' => 'required|string',
            'followers' => 'required|integer|min:1',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'biaya_responden' => 'required|integer|min:0',
            'relevansi_responden' => 'required|in:Sangat Baik,Baik,Cukup,Kurang',
        ]);

        Responden::create($request->all());

        return redirect()->route('responden.index')->with('success', 'Data responden berhasil ditambahkan.');
    }
    

    public function update(Request $request, $id)
{
    $request->validate([
        'kode_responden' => 'required|string|unique:responden,kode_responden,' . $id,
        'nama_responden' => 'required|string|max:255',
        'email_responden' => 'required|email|max:255',
        'platform_responden' => 'required|string',
        'kategori_responden' => 'required|string',
        'followers' => 'required|integer|min:1',
        'likes' => 'required|integer|min:0',
        'comments' => 'required|integer|min:0',
        'biaya_responden' => 'required|integer|min:0',
        'relevansi_responden' => 'required|in:Sangat Baik,Baik,Cukup,Kurang',
    ]);

    $responden = Responden::findOrFail($id);
    $responden->update($request->all());

    // Tambahkan ini untuk update otomatis Normalisasi & Terbobot
    app(\App\Http\Controllers\SinkronisasiController::class)->sinkronisasi();

    return redirect()->route('responden.index')->with('success', 'Data responden berhasil diperbarui dan data normalisasi serta terbobot diperbarui.');
}


    public function destroy($id)
{
    // Ambil data responden berdasarkan id
    $responden = Responden::findOrFail($id);
    $kode = $responden->kode_responden;

    // Cari data influencer terkait menggunakan kode_responden
    $influencer = \App\Models\Influencer::where('kode_responden', $kode)->first();

    if ($influencer) {
        // Hapus data normalisasi terkait
        \App\Models\Normalisasi::where('alternatif_id', $influencer->id)->delete();

        // Hapus data terbobot terkait
        \App\Models\Terbobot::where('alternatif_id', $influencer->id)->delete();

        // Hapus influencer terkait
        $influencer->delete();
    }

    // Hapus data responden
    $responden->delete();

    return redirect()->route('responden.index')->with('success', 'Data responden, data alternatif, data normalisasi, dan data terbobot berhasil dihapus.');
}



}
