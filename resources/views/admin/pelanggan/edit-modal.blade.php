<!-- Modal Edit Pelanggan -->
<div id="editModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-40 z-50 items-center justify-center">
    <div class="bg-white rounded-lg shadow p-6 w-full max-w-2xl relative">
        <h2 class="text-xl font-bold mb-4">✏️ Edit Pelanggan</h2>

        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <input type="hidden" name="id_pelanggan" id="edit_id_pelanggan">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_pelanggan" id="edit_nama_pelanggan" class="w-full border rounded px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Tarif Listrik</label>
                    <select name="id_tarif" id="edit_id_tarif" class="w-full border rounded px-4 py-2">
                        @foreach($tarifs as $tarif)
                        <option value="{{ $tarif->id_tarif }}">{{ $tarif->kode_tarif }} - {{ $tarif->daya }} VA</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full border rounded px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nomor Telp</label>
                    <input type="text" name="no_telp" id="edit_no_telp" class="w-full border rounded px-4 py-2">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Nomor KWH</label>
                    <input type="text" name="nomor_kwh" id="edit_nomor_kwh" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-600" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <input type="text" name="status" id="edit_status" class="w-full border rounded px-4 py-2 bg-gray-100 text-gray-600" readonly>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-1">Alamat</label>
                    <textarea name="alamat" id="edit_alamat" class="w-full border rounded px-4 py-2" rows="3"></textarea>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="button" onclick="closeEditModal()" class="text-sm text-gray-600 hover:underline">Batal</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
