{{--  resources/views/admin/metode/edit.blade.php  --}}
@extends('admin.index')

@section('content')
    <!-- Wrapper -->
    <div class="bg-white shadow rounded-lg p-6">
        <!-- Header -->
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-1">Edit Metode Pembayaran</h2>
            <p class="text-sm text-gray-500">Perbarui informasi metode pembayaran.</p>
        </div>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <form action="{{ route('metode.update', $metode) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $metode->nama) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: Bank BCA" required>
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode -->
                <div>
                    <label for="kode" class="block text-sm font-medium text-gray-700 mb-2">
                        Kode <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="kode" name="kode" value="{{ old('kode', $metode->kode) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: BCA" maxlength="10" required>
                    @error('kode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Atas Nama -->
                <div>
                    <label for="atas_nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Atas Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="atas_nama" name="atas_nama" value="{{ old('atas_nama', $metode->atas_nama) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: PT. Voltix Listrik" required>
                    @error('atas_nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Rekening -->
                <div>
                    <label for="nomor_rekening" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Rekening/HP
                    </label>
                    <input type="text" id="nomor_rekening" name="nomor_rekening"
                        value="{{ old('nomor_rekening', $metode->nomor_rekening) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: 1234567890">
                    @error('nomor_rekening')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Biaya Admin -->
                <div>
                    <label for="biaya_admin" class="block text-sm font-medium text-gray-700 mb-2">
                        Biaya Admin <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="biaya_admin" name="biaya_admin"
                        value="{{ old('biaya_admin', $metode->biaya_admin) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="0" min="0" step="0.01" required>
                    @error('biaya_admin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo -->
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo
                    </label>
                    @if ($metode->logo)
                        <div class="mb-2">
                            <img src="{{ $metode->logo_url }}" alt="Current Logo"
                                class="w-16 h-16 object-contain border rounded">
                            <p class="text-xs text-gray-500 mt-1">Logo saat ini</p>
                        </div>
                    @endif
                    <input type="file" id="logo" name="logo"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        accept="image/*">
                    <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin
                        mengubah.</p>
                    @error('logo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Deskripsi metode pembayaran...">{{ old('deskripsi', $metode->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Aktif -->
            <div>
                <div class="flex items-center">
                    <input type="checkbox" id="is_aktif" name="is_aktif" value="1"
                        {{ old('is_aktif', $metode->is_aktif) ? 'checked' : '' }}
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_aktif" class="ml-2 text-sm font-medium text-gray-700">
                        Aktifkan metode pembayaran ini
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('metode.index') }}"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
@endsection
