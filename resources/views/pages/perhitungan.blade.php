@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Hasil Perhitungan Fuzzy TOPSIS</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-black text-sm">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Kode Responden</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Platform</th>
                    <th class="border px-4 py-2">Kategori</th>
                    <th class="border px-4 py-2">Nilai Preferensi (V)</th>
                    <th class="border px-4 py-2">Ranking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hasil as $index => $item)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-4 py-2">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2">{{ $item['kode_responden'] }}</td>
                    <td class="border px-4 py-2">{{ $item['nama'] }}</td>
                    <td class="border px-4 py-2">{{ $item['platform'] }}</td>
                    <td class="border px-4 py-2">{{ $item['kategori'] }}</td>
                    <td class="border px-4 py-2">{{ number_format($item['V'], 4) }}</td>
                    <td class="border px-4 py-2 font-semibold">{{ $index + 1 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if (empty($hasil))
        <p class="text-center text-gray-600 mt-4">Belum ada data yang dapat dihitung.</p>
        @endif
    </div>
</div>
@endsection
