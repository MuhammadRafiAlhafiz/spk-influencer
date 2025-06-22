@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Data Influencer</h1>

    {{-- Button tambah (khusus admin) --}}
    @if(Auth::user()->role === 'admin')
    <button onclick="openModal('modalTambah')" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">
        Tambah Influencer
    </button>
    @endif

    {{-- Tabel data --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-black">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">Platform</th>
                    <th class="border px-4 py-2">Kategori</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="border px-4 py-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($influencers as $influencer)
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ $influencer->id }}</td>
                    <td class="border px-4 py-2">{{ $influencer->nama }}</td>
                    <td class="border px-4 py-2">{{ $influencer->platform }}</td>
                    <td class="border px-4 py-2">{{ $influencer->kategori }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td class="border px-4 py-2">
                        <button onclick="openEditModal({{ $influencer }})" class="text-blue-600 hover:underline">Edit</button>
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
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Tambah Influencer</h2>
        <form action="{{ route('influencer.store') }}" method="POST">
            @csrf
            <input name="nama" placeholder="Nama" class="w-full border p-2 mb-2" required>
            <input name="platform" placeholder="Platform" class="w-full border p-2 mb-2" required>
            <input name="kategori" placeholder="Kategori" class="w-full border p-2 mb-2" required>
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
            <input name="nama" id="editNama" class="w-full border p-2 mb-2" required>
            <input name="platform" id="editPlatform" class="w-full border p-2 mb-2" required>
            <input name="kategori" id="editKategori" class="w-full border p-2 mb-2" required>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript Modal --}}
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    function openEditModal(data) {
        const form = document.getElementById('editForm');
        form.action = '/influencer/' + data.id;
        document.getElementById('editNama').value = data.nama;
        document.getElementById('editPlatform').value = data.platform;
        document.getElementById('editKategori').value = data.kategori;
        openModal('modalEdit');
    }
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

</script>
@endsection
