@extends('admin.index')

@section('content')
    <div class="bg-white p-6 rounded shadow max-w-xl mx-auto">
        <h2 class="text-xl font-bold mb-4">Tambah Pelanggan</h2>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <form action="{{ route('admin.pelanggan.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Nama Lengkap</label>
                <input type="text" name="nama_pelanggan" placeholder="Nama lengkap" value="{{ old('nama_pelanggan') }}"
                    class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Nomor KWH</label>
                <input type="text" name="nomor_kwh" value="{{ $nomor_kwh }}"
                    class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-600" readonly>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Alamat</label>
                <textarea name="alamat" class="w-full border rounded px-4 py-2" rows="3">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Tarif Listrik</label>
                <select name="id_tarif" class="w-full border rounded px-4 py-2">
                    <option value="">-- Pilih Tarif --</option>
                    @foreach ($tarifs as $tarif)
                        <option value="{{ $tarif->id_tarif }}" {{ old('id_tarif') == $tarif->id_tarif ? 'selected' : '' }}>
                            {{ $tarif->kode_tarif }} - {{ $tarif->daya }} VA
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded px-4 py-2">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-4 py-2">
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('admin.pelanggan.index') }}" class="text-sm text-gray-600 hover:underline">← Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
