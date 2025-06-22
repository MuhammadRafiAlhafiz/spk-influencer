<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influencer;

class InfluencerController extends Controller
{
    public function index()
    {
        $influencers = Influencer::all();
        return view('pages.alternatif', compact('influencers'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'platform' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
        ]);

        Influencer::create($request->all());

        return redirect()->route('alternatif.index')->with('success', 'Influencer berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $influencer = Influencer::findOrFail($id);
        return view('pages.edit', compact('influencer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'platform' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
        ]);

        $influencer = Influencer::findOrFail($id);
        $influencer->update($request->all());

        return redirect()->route('alternatif.index')->with('success', 'Influencer berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $influencer = Influencer::findOrFail($id);
        $influencer->delete();

        return redirect()->route('alternatif.index')->with('success', 'Influencer berhasil dihapus!');
    }
}
