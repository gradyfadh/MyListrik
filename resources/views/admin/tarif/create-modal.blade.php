<!-- Modal Tambah Tarif -->
<div id="createModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
        <h2 class="text-xl font-bold mb-4">Tambah Tarif Listrik</h2>

        <form action="{{ route('tarif.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="kode_tarif" class="block text-sm font-medium mb-1">Kode Tarif</label>
                <input type="text" name="kode_tarif" id="kode_tarif" value="{{ old('kode_tarif') }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="daya" class="block text-sm font-medium mb-1">Daya (VA)</label>
                <input type="number" name="daya" id="daya" value="{{ old('daya') }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="tarifperkwh" class="block text-sm font-medium mb-1">Tarif per KWh (Rp)</label>
                <input type="number" name="tarifperkwh" id="tarifperkwh" step="0.01" value="{{ old('tarifperkwh') }}"
                    class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                    class="w-full border rounded p-2">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="button" onclick="closeCreateModal()" class="text-gray-600 hover:underline">Batal</button>
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
