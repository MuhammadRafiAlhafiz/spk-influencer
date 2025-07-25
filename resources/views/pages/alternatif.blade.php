@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Alternatif Influencer</h1>

    <div>
        <table class="w-full border border-black text-sm">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-2 py-2">Kode Responden</th>
                    <th class="border px-2 py-2">Nama</th>
                    <th class="border px-2 py-2">Platform</th>
                    <th class="border px-2 py-2">Kategori</th>
                    <th class="border px-2 py-2">Engagement</th>
                    <th class="border px-2 py-2">Biaya</th>
                    <th class="border px-2 py-2">Relevansi Konten</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($influencers as $influencer)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-2 py-2">{{ $influencer->kode_responden }}</td>
                    <td class="border px-2 py-2 truncate max-w-[150px]">{{ $influencer->nama_alternatif }}</td>
                    <td class="border px-2 py-2">{{ $influencer->platform_alternatif }}</td>
                    <td class="border px-2 py-2">{{ $influencer->kategori_alternatif }}</td>
                    <td class="border px-2 py-2">{{ number_format($influencer->engagement_alternatif, 2) }}%</td>
                    <td class="border px-2 py-2 text-left">
                        <span class="text-gray-700">Rp</span> {{ number_format($influencer->biaya_alternatif,0,',','.') }}
                    </td>
                    <td class="border px-2 py-2">{{ $influencer->relevansi_alternatif }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-600">Belum ada data alternatif. Silakan input data melalui halaman Responden.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
