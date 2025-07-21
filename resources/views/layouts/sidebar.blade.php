<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brand Fashion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex min-h-screen">

        <!-- Sidebar -->
<aside class="fixed top-0 left-0 w-64 h-screen bg-white shadow-md flex flex-col z-20">
    <!-- Bagian Atas (Judul + Menu) -->
    <div>
        <p class="text-gray-700 text-center mt-5">You're logged in as {{ Auth::user()->role }}!</p>
        <div class="p-6 font-bold text-xl border-b">
            Pemilihan Influencer
        </div>
        <nav class="p-5 space-y-2">
        <div class="justify-between">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>

<details class="group">
    <summary class="cursor-pointer px-3 py-2 rounded hover:bg-gray-100 flex justify-between items-center">
        <span>Input Data</span>
        <svg class="w-4 h-4 ml-2 transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </summary>
    <div class="pl-4 mt-2 space-y-1">
        <a href="{{ route('alternatif.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Data Alternatif</a>
        <a href="{{ route('kriteria.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Data Kriteria</a>
        <a href="{{ route('normalisasi.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Data Normalisasi</a>
    </div>
</details>

<a href="{{ route('perhitungan.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Perhitungan Hasil</a>
<a href="{{ route('penilaian.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Nilai Alternatif</a>

        </div>
        </nav>
    </div>

    <!-- Bagian Bawah (User Info + Logout) -->
    <div class="p-4 border-t">
        <div class="text-gray-700 font-semibold">
            {{ Auth::user()->name }}
        </div>
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:underline">
                Logout
            </button>
        </form>
    </div>
</aside>

        <!-- Content -->
        <main class="flex-1 p-6 ml-64">
            <h2 class="text-2xl font-bold text-gray-800">@yield('title')</h2>
            <div class="mt-4">
                @yield('content')
            </div>
        </main>
    </div>
</div>

</form>
</body>
</html>
