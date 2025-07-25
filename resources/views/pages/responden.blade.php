@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Responden Influencer</h1>

    @if(Auth::user()->role === 'admin')
    <button onclick="openModal('modalTambah')" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">
        Tambah Responden
    </button>
    @endif

    @if(Auth::user()->role === 'admin')
    <form action="{{ route('responden.sinkronisasi') }}" method="POST" onsubmit="return confirm('Sinkronkan semua data ke Alternatif dan Normalisasi?')">
    @csrf
    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded mb-4 hover:bg-green-700">
        Sinkronkan ke Alternatif & Normalisasi
    </button>
    </form>
    @endif

    @if(session('success'))
<div class="bg-green-100 text-green-800 p-2 rounded mb-2">
    {{ session('success') }}
</div>
@endif

@if(session('info'))
<div class="bg-blue-100 text-blue-800 p-2 rounded mb-2">
    {{ session('info') }}
</div>
@endif


    <div>
        <table class="w-full border border-black text-sm">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-2 py-2">kode Responden</th>
                    <th class="border px-2 py-2">Nama</th>
                    <th class="border px-2 py-2">Email</th>
                    <th class="border px-2 py-2">Platform</th>
                    <th class="border px-2 py-2">Kategori</th>
                    <th class="border px-2 py-2">Followers</th>
                    <th class="border px-2 py-2">Likes</th>
                    <th class="border px-2 py-2">Comments</th>
                    <th class="border px-4 py-2">Biaya</th>
                    <th class="border px-2 py-2">Relevansi</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="border px-2 py-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($responden as $data)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-4 py-2">{{ $data->kode_responden }}</td>
                    <td class="border px-2 py-2 truncate max-w-[150px]">{{ $data->nama_responden }}</td>
                    <td class="border px-2 py-2 truncate max-w-[180px]">{{ $data->email_responden }}</td>
                    <td class="border px-2 py-2 truncate max-w-[120px]">{{ $data->platform_responden }}</td>
                    <td class="border px-2 py-2 truncate max-w-[120px]">{{ $data->kategori_responden }}</td>
                    <td class="border px-2 py-2">{{ number_format($data->followers) }}</td>
                    <td class="border px-2 py-2">{{ number_format($data->likes) }}</td>
                    <td class="border px-2 py-2">{{ number_format($data->comments) }}</td>
                    <td class="border px-2 py-2 text-left">
                        <span class="text-gray-700">Rp</span> {{ number_format($data->biaya_responden,0,',','.') }}
                    </td>
                    <td class="border px-2 py-2">{{ $data->relevansi_responden }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td class="border px-2 py-2">
                        <div class="flex justify-center space-x-2">
                            <button onclick='openEditModal(@json($data))' class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                <i data-feather="edit"></i>
                            </button>
                        <form action="{{ route('responden.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
        <i data-feather="trash-2"></i>
    </button>
</form>


                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($responden->isEmpty())
        <p class="text-center text-gray-600 mt-4">Belum ada data responden. Silakan tambahkan data terlebih dahulu.</p>
        @endif
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Tambah Responden Influencer</h2>
        <form action="{{ route('responden.store') }}" method="POST">
            @csrf
            <input name="kode_responden" placeholder="Kode Responden" class="w-full border p-2 mb-2" required>
            @error('kode_responden')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <input name="nama_responden" placeholder="Nama" class="w-full border p-2 mb-2" required>
            <input name="email_responden" placeholder="Email" type="email" class="w-full border p-2 mb-2" required>
            <select name="platform_responden" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Platform</option>
                <option value="Instagram">Instagram</option>
                <option value="Tiktok">Tiktok</option>
                <option value="Facebook">Facebook</option>
            </select>
            <select name="kategori_responden" class="w-full border p-2 mb-2" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="Casual Style">Casual Style</option>
                <option value="Chic Style">Chic Style</option>
                <option value="Streetwear Look">Streetwear Look</option>
                <option value="Formal Style">Formal Style</option>
                <option value="Vintage Style">Vintage Style</option>
            </select>
            <input name="followers" type="number" placeholder="Jumlah Followers" class="w-full border p-2 mb-2" required>
            <input name="likes" type="number" placeholder="Jumlah Likes dari 10 postingan" class="w-full border p-2 mb-2" required>
            <input name="comments" type="number" placeholder="Jumlah Comments 10 postingan" class="w-full border p-2 mb-2" required>
            <input name="biaya_responden" type="number" placeholder="Biaya (Rp)" class="w-full border p-2 mb-2" required>
            <select name="relevansi_responden" class="w-full border p-2 mb-2" required>
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
        <h2 class="text-xl font-semibold mb-4">Edit Responden Influencer</h2>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
<input name="kode_responden" id="editKode" placeholder="Kode Responden" class="w-full border p-2 mb-2" required>
                @error('kode_responden')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            <input name="nama_responden" id="editNama" class="w-full border p-2 mb-2" required>
            <input name="email_responden" id="editEmail" type="email" class="w-full border p-2 mb-2" required>
            <select name="platform_responden" id="editPlatform" class="w-full border p-2 mb-2" required>
                <option value="Instagram">Instagram</option>
                <option value="Tiktok">Tiktok</option>
                <option value="Facebook">Facebook</option>
            </select>
            <select name="kategori_responden" id="editKategori" class="w-full border p-2 mb-2" required>
                <option value="Casual Style">Casual Style</option>
                <option value="Chic Style">Chic Style</option>
                <option value="Streetwear Look">Streetwear Look</option>
                <option value="Formal Style">Formal Style</option>
                <option value="Vintage Style">Vintage Style</option>
            </select>
            <input name="followers" id="editFollowers" type="number" class="w-full border p-2 mb-2" required>
            <input name="likes" id="editLikes" type="number" class="w-full border p-2 mb-2" required>
            <input name="comments" id="editComments" type="number" class="w-full border p-2 mb-2" required>
            <input name="biaya_responden" id="editBiaya" type="number" class="w-full border p-2 mb-2" required>
            <select name="relevansi_responden" id="editRelevansi" class="w-full border p-2 mb-2" required>
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


<script src="https://unpkg.com/feather-icons"></script>
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
    form.action = '/responden/' + data.id;

    document.getElementById('editKode').value = data.kode_responden ?? '';
    document.getElementById('editNama').value = data.nama_responden ?? '';
    document.getElementById('editEmail').value = data.email_responden ?? '';
    document.getElementById('editPlatform').value = data.platform_responden ?? '';
    document.getElementById('editKategori').value = data.kategori_responden ?? '';
    document.getElementById('editFollowers').value = data.followers ?? '';
    document.getElementById('editLikes').value = data.likes ?? '';
    document.getElementById('editComments').value = data.comments ?? '';
    document.getElementById('editBiaya').value = data.biaya_responden ?? '';
    document.getElementById('editRelevansi').value = data.relevansi_responden ?? '';

    openModal('modalEdit');
}

document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
});
</script>
@endsection
