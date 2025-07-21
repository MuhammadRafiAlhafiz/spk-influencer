<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FuzzyTopsisController extends Controller
{
    public function index()
    {
        return view('pages.hasil');
    }

    public function proses(Request $request)
    {
        // logika fuzzy topsis nanti di sini
    }
}
