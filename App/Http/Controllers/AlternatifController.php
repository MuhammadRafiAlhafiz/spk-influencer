<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Influencer;

class InfluencerController extends Controller
{
    public function index()
    {
        $influencers = Influencer::all();
        return view('layouts.pages.alternatif', compact('influencers'));
    }
}
