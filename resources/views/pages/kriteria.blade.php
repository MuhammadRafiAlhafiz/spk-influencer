@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Kriteria</h1>

    {{-- Alert error --}}
    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <strong>Oops!</strong> Ada kesalahan dalam input:
        <ul class="mt-2 ml-4 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Tombol Tambah --}}
    @if(Auth::user()->role === 'admin')
    <button onclick="openModal('modalTambah')" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">
        Tambah Kriteria
    </button>
    @endif

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-black">
            <thead class="bg-gray-300">
                <tr>
                    <th class="border px-4 py-2">Kode</th>
                    <th class="border px-4 py-2">Nama Kriteria</th>
                    <th class="border px-4 py-2">Bobot Kriteria</th>
                    @if(Auth::user()->role === 'admin')
                    <th class="border px-4 py-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($kriterias as $kriteria)
                <tr class="hover:bg-gray-100 text-center">
                    <td class="border px-4 py-2">{{ $kriteria->kode_kriteria }}</td>
                    <td class="border px-4 py-2">{{ $kriteria->nama_kriteria }}</td>
                    <td class="border px-4 py-2">{{ str_replace('.', ',', $kriteria->bobot_kriteria) }}</td>
                    @if(Auth::user()->role === 'admin')
                    <td class="border px-4 py-2 space-x-1">
                        <button onclick="openEditModal({{ $kriteria }})" class="text-blue-600 hover:underline">Edit</button>
                        <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline ml-2">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($kriterias->isEmpty())
        <p class="text-center text-gray-600 mt-4">Belum ada data kriteria.</p>
        @endif
    </div>
</div>

{{-- Modal Tambah --}}
<div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 justify-center items-center hidden z-50">
    <div class="bg-white p-6 rounded w-full max-w-md">
        <h2 class="text-xl font-semibold mb-4">Tambah Kriteria</h2>
        <form action="{{ route('kriteria.store') }}" method="POST">
            @csrf
            <input name="kode_kriteria" placeholder="Kode Kriteria" class="w-full border p-2 mb-2" required value="{{ old('kode_kriteria') }}">
            @error('kode_kriteria')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <input name="nama_kriteria" placeholder="Nama Kriteria" class="w-full border p-2 mb-2" required value="{{ old('nama_kriteria') }}">
            @error('nama_kriteria')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

            <input name="bobot_kriteria" id="bobot_kriteria" placeholder="Bobot Kriteria (contoh: 5 akan menjadi 0,5)" class="w-full border p-2 mb-2" required value="{{ old('bobot_kriteria') }}">
            @error('bobot_kriteria')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror

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
        <h2 class="text-xl font-semibold mb-4">Edit Kriteria</h2>
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <input name="kode_kriteria" id="editKode" placeholder="Kode Kriteria" class="w-full border p-2 mb-2" required>
            <input name="nama_kriteria" id="editNamaKriteria" placeholder="Nama Kriteria" class="w-full border p-2 mb-2" required>
            <input name="bobot_kriteria" id="editBobotKriteria" placeholder="Bobot Kriteria" class="w-full border p-2 mb-2" required>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal('modalEdit')" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- JavaScript --}}
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
    document.getElementById(id).classList.add('flex');
}
function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
    document.getElementById(id).classList.remove('flex');
}
function openEditModal(data) {
    const form = document.getElementById('editForm');
    form.action = '/kriteria/' + data.id;
    document.getElementById('editKode').value = data.kode_kriteria ?? '';
    document.getElementById('editNamaKriteria').value = data.nama_kriteria ?? '';
    document.getElementById('editBobotKriteria').value = data.bobot_kriteria ?? '';
    openModal('modalEdit');
}
</script>
@endsection
