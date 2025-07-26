<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg relative">
        <h2 class="text-xl font-bold mb-4">Edit Tarif Listrik</h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_tarif" id="edit_id_tarif">

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Kode Tarif</label>
                <input type="text" name="kode_tarif" id="edit_kode_tarif" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Daya</label>
                <input type="number" name="daya" id="edit_daya" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Tarif per KWh</label>
                <input type="number" name="tarifperkwh" id="edit_tarifperkwh" step="0.01" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="edit_deskripsi" rows="3" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="button" onclick="closeEditModal()" class="text-gray-600 hover:underline">Batal</button>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
