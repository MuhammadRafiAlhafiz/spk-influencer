@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Influencer</h1>

    @if(Auth::user()->role === 'admin')
    <button onclick="openModal('modalTambah')" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">
        Tambah Influencer
    </button>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full border border-black">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Platform</th>
                    <th class="border px-4 py-2">Kategori</th>
                    <th class="border px-4 py-2">Engagement</th>
                    <th class="border px-4 py-2">Biaya</th>
                    <th class="border px-4 py-2">Relevansi Konten</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="border px-4 py-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($influencers as $influencer)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2 whitespace-nowrap text-center">{{ $influencer->nama_alternatif }}</td>
                    <td class="border px-4 py-2">{{ $influencer->platform_alternatif }}</td>
                    <td class="border px-4 py-2 whitespace-nowrap text-center">{{ $influencer->kategori_alternatif }}</td>
                    <td class="border px-4 py-2">{{ number_format($influencer->engagement_alternatif, 2) }}%</td>
                    <td class="border px-4 py-2 whitespace-nowrap text-center">{{ 'Rp ' . number_format($influencer->biaya_alternatif,0,',','.') }}</td>
                    <td class="border px-4 py-2">{{ $influencer->relevansi_alternatif }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td class="border px-4 py-2 whitespace-nowrap text-center">
                        <button onclick='openEditModal(@json($influencer))' class="text-blue-600 hover:underline">Edit</button>
                        <form action="{{ route('influencer.destroy', $influencer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($influencers->isEmpty())
            <p class="text-center text-gray-600 mt-4">Belum ada data alternatif. Silakan tambahkan data terlebih dahulu.</p>
        @endif
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Tambah Influencer</h2>
        <form action="{{ route('influencer.store') }}" method="POST">
            @csrf
            <input name="nama_alternatif" placeholder="Nama" class="w-full border p-2 mb-2" required>
            <select name="platform_alternatif" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Platform</option>
                <option value="Instagram">Instagram</option>
                <option value="Tiktok">Tiktok</option>
                <option value="Facebook">Facebook</option>
            </select>
            <select name="kategori_alternatif" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="Casual Style">Casual Style</option>
                <option value="Chic Style">Chic Style</option>
                <option value="Streetwear Look">Streetwear Look</option>
                <option value="Formal Style">Formal Style</option>
                <option value="Vintage Style">Vintage Style</option>
            </select>
            <input name="followers" type="number" placeholder="Jumlah Followers" class="w-full border p-2 mb-2" required>
            <input name="likes" type="number" placeholder="Jumlah Likes" class="w-full border p-2 mb-2" required>
            <input name="comments" type="number" placeholder="Jumlah Comments" class="w-full border p-2 mb-2" required>
            <input name="biaya_alternatif" type="number" placeholder="Biaya (Rp)" class="w-full border p-2 mb-2" required>
            <select name="relevansi_alternatif" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Relevansi Konten</option>
                <option value="Sangat Baik">Sangat Baik</option>
                <option value="Baik">Baik</option>
                <option value="Cukup">Cukup</option>
                <option value="Kurang">Kurang</option>
            </select>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('modalTambah')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Edit Influencer</h2>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <input name="nama_alternatif" id="editNama" class="w-full border p-2 mb-2" required>
            <select name="platform_alternatif" id="editPlatform" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Platform</option>
                <option value="Instagram">Instagram</option>
                <option value="Tiktok">Tiktok</option>
                <option value="Facebook">Facebook</option>
            </select>
            <select name="kategori_alternatif" id="editKategori" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="Casual Style">Casual Style</option>
                <option value="Chic Style">Chic Style</option>
                <option value="Streetwear Look">Streetwear Look</option>
                <option value="Formal Style">Formal Style</option>
                <option value="Vintage Style">Vintage Style</option>
            </select>
            <input name="followers" id="editFollowers" type="number" placeholder="Jumlah Followers" class="w-full border p-2 mb-2" required>
            <input name="likes" id="editLikes" type="number" placeholder="Jumlah Likes" class="w-full border p-2 mb-2" required>
            <input name="comments" id="editComments" type="number" placeholder="Jumlah Comments" class="w-full border p-2 mb-2" required>
            <input name="biaya_alternatif" id="editBiaya" type="number" placeholder="Biaya (Rp)" class="w-full border p-2 mb-2" required>
            <select name="relevansi_alternatif" id="editRelevansi" class="w-full border p-2 mb-2" required>
                <option value="" disabled>Pilih Relevansi Konten</option>
                <option value="Sangat Baik">Sangat Baik</option>
                <option value="Baik">Baik</option>
                <option value="Cukup">Cukup</option>
                <option value="Kurang">Kurang</option>
            </select>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
function openEditModal(data) {
    const form = document.getElementById('editForm');
    form.action = '/alternatif/' + data.id;

    document.getElementById('editNama').value = data.nama_alternatif ?? '';
    document.getElementById('editPlatform').value = data.platform_alternatif ?? '';
    document.getElementById('editKategori').value = data.kategori_alternatif ?? '';
    document.getElementById('editFollowers').value = data.followers ?? '';
    document.getElementById('editLikes').value = data.likes ?? '';
    document.getElementById('editComments').value = data.comments ?? '';
    document.getElementById('editBiaya').value = data.biaya_alternatif ?? '';
    document.getElementById('editRelevansi').value = data.relevansi_alternatif ?? '';

    openModal('modalEdit');
}
</script>
@endsection
