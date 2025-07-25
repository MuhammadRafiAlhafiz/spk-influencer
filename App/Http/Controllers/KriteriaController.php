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
            'kode_kriteria' => 'required|string|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required|string',
            'bobot_kriteria' => 'required',
        ]);

        // Ubah koma ke titik jika user mengetik koma
        $bobot_input = str_replace(',', '.', $request->bobot_kriteria);

        // Jika admin mengetik >= 1, otomatis dibagi 10
        if (floatval($bobot_input) >= 1) {
            $bobot_kriteria = floatval($bobot_input) / 10; // 5 menjadi 0.5
        } else {
            $bobot_kriteria = floatval($bobot_input);
        }

        Kriteria::create([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot_kriteria' => $bobot_kriteria,
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_kriteria' => 'required|string|unique:kriterias,kode_kriteria,' . $id,
            'nama_kriteria' => 'required|string',
            'bobot_kriteria' => 'required',
        ]);

        $bobot_input = str_replace(',', '.', $request->bobot_kriteria);

        if (floatval($bobot_input) >= 1) {
            $bobot_kriteria = floatval($bobot_input) / 10;
        } else {
            $bobot_kriteria = floatval($bobot_input);
        }

        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update([
            'kode_kriteria' => $request->kode_kriteria,
            'nama_kriteria' => $request->nama_kriteria,
            'bobot_kriteria' => $bobot_kriteria,
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
