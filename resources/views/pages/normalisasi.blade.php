@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Normalisasi</h1>

    <div class="overflow-x-auto mb-10">
        <table class="min-w-full border border-black">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">Kode Responden</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Engagement (Norm)</th>
                    <th class="border px-4 py-2">Biaya (Norm)</th>
                    <th class="border px-4 py-2">Relevansi (Norm)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataNormalisasi as $data)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-4 py-2">{{ $data['kode_responden'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $data['nama'] ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ number_format($data['engagement'], 4) }}</td>
                    <td class="border px-4 py-2">{{ number_format($data['biaya'], 4) }}</td>
                    <td class="border px-4 py-2">{{ number_format($data['relevansi'], 4) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if(empty($dataNormalisasi))
            <p class="text-center text-gray-600 mt-4">Belum ada data normalisasi.</p>
        @endif
    </div>
</div>
@endsection
