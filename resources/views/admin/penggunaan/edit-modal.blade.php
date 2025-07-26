<!-- Modal Edit Penggunaan -->
<div id="editTagihanModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 flex-col">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl relative">
        <h2 class="text-xl font-bold mb-4">Edit Penggunaan Listrik</h2>

        <form id="editTagihanForm" method="POST">
            @csrf
            @method('PUT')

            {{-- Hidden ID --}}
            <input type="hidden" id="edit_id_penggunaan" name="id_penggunaan">

            {{-- Pilih Pelanggan --}}
            <div class="mb-4">
                <label for="edit_id_pelanggan" class="block text-sm font-medium mb-1">Pilih Pelanggan</label>
                <select name="id_pelanggan" id="edit_id_pelanggan" required class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Pelanggan --</option>
                    @forelse($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}">
                            {{ $pelanggan->nama_pelanggan }} ({{ $pelanggan->nomor_kwh }})
                        </option>
                    @empty
                        <option value="">Tidak ada pelanggan aktif</option>
                    @endforelse
                </select>
            </div>

            {{-- Bulan --}}
            <div class="mb-4">
                <label for="edit_bulan" class="block text-sm font-medium mb-1">Bulan</label>
                <select name="bulan" id="edit_bulan" required class="w-full border rounded px-3 py-2">
                    @foreach (range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">
                            {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="edit_tahun" class="block text-sm font-medium mb-1">Tahun</label>
                <input type="number" name="tahun" id="edit_tahun" required class="w-full border rounded px-3 py-2">
            </div>

            {{-- Meter Awal --}}
            <div class="mb-4">
                <label for="edit_meter_awal" class="block text-sm font-medium mb-1">Meter Awal</label>
                <input type="number" name="meter_awal" id="edit_meter_awal" class="w-full border px-3 py-2 rounded"
                    required>
            </div>

            {{-- Meter Akhir --}}
            <div class="mb-4">
                <label for="edit_meter_akhir" class="block text-sm font-medium mb-1">Meter Akhir</label>
                <input type="number" name="meter_akhir" id="edit_meter_akhir" class="w-full border px-3 py-2 rounded"
                    required>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center mt-6">
                <button type="button" onclick="closeEditTagihanModal()"
                    class="text-gray-600 hover:underline">Batal</button>
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
