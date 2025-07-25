@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Terbobot</h1>

    <div class="overflow-x-auto mb-10">
        <table class="min-w-full border border-black text-sm">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Kode Responden</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Engagement (Terbobot)</th>
                    <th class="border px-4 py-2">Biaya (Terbobot)</th>
                    <th class="border px-4 py-2">Relevansi (Terbobot)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dataTerbobot as $item)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $item['kode_responden'] }}</td>
                    <td class="border px-4 py-2">{{ $item['nama'] }}</td>
                    <td class="border px-4 py-2">{{ number_format($item['engagement'], 4) }}</td>
                    <td class="border px-4 py-2">{{ number_format($item['biaya_terbobot'], 4) }}</td>
                    <td class="border px-4 py-2">{{ number_format($item['relevansi_terbobot'], 4) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Belum ada data terbobot</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
