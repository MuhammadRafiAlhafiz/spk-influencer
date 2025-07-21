<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
{
    $kriterias = Kriteria::all();
    return view('pages.kriteria', compact('kriterias'));
}

    public function store(Request $request)
{
    $request->validate([
        'kode_kriteria' => 'required|string|max:10',
        'nama_kriteria' => 'required|string|max:255',
        'bobot_kriteria' => 'required|numeric|min:0',
    ]);

    Kriteria::create([
        'kode_kriteria' => $request->kode_kriteria,
        'nama_kriteria' => $request->nama_kriteria,
        'bobot_kriteria' => $request->bobot_kriteria,
    ]);

    return back()->with('success', 'Kriteria berhasil ditambahkan.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'kode_kriteria' => 'required|string|max:10',
        'nama_kriteria' => 'required|string|max:255',
        'bobot_kriteria' => 'required|numeric|min:0',
    ]);

    $kriteria = Kriteria::findOrFail($id);

    $kriteria->update([
        'kode_kriteria' => $request->kode_kriteria,
        'nama_kriteria' => $request->nama_kriteria,
        'bobot_kriteria' => $request->bobot_kriteria,
    ]);

    return back()->with('success', 'Kriteria berhasil diperbarui.');
}


    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();
        return back()->with('success', 'Kriteria berhasil dihapus.');
    }
}
