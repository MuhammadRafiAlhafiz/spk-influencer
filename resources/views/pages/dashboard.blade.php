@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-lg shadow p-5 flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
            </div>
            <div>
                <p class="text-sm">Total Responden</p>
                <p class="text-2xl font-bold">{{ $totalResponden }}</p>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-700 text-white rounded-lg shadow p-5 flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <div>
                <p class="text-sm">Total Alternatif</p>
                <p class="text-2xl font-bold">{{ $totalAlternatif }}</p>
            </div>
        </div>

        <div class="bg-gradient-to-r from-yellow-500 to-yellow-700 text-white rounded-lg shadow p-5 flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-9 4h9m-4 4h4" />
                </svg>
            </div>
            <div>
                <p class="text-sm">Total Kriteria</p>
                <p class="text-2xl font-bold">{{ $totalKriteria }}</p>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-700 text-white rounded-lg shadow p-5 flex items-center">
            <div class="p-3 bg-white bg-opacity-20 rounded-full mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
            </div>
            <div>
                <p class="text-sm">Total Normalisasi</p>
                <p class="text-2xl font-bold">{{ $totalNormalisasi }}</p>
            </div>
        </div>
    </div>

    {{-- Welcome Section --}}
    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-3">Selamat Datang di Dashboard SPK Influencer 🎉</h2>
        <p class="text-gray-600 leading-relaxed">
            Sistem Pendukung Keputusan ini membantu Anda dalam menentukan influencer terbaik untuk brand fashion menggunakan metode Fuzzy TOPSIS.
            Gunakan menu di samping untuk mengelola <strong>Data Responden, Alternatif, Kriteria, Normalisasi,</strong> serta melakukan perhitungan hasil untuk mendapatkan rekomendasi influencer terbaik.
        </p>
    </div>
</div>
@endsection
