<!-- Modal Tambah Penggunaan -->
<div id="createTagihanModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 flex-col">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-xl relative">
        <h2 class="text-xl font-bold mb-4">Tambah Penggunaan Listrik</h2>

        <form action="{{ route('admin.penggunaan.store') }}" method="POST">
            @csrf

            {{-- Pilih Pelanggan --}}
            <div class="mb-4">
                <label for="id_pelanggan" class="block text-sm font-medium mb-1">Pilih Pelanggan</label>
                <select name="id_pelanggan" id="id_pelanggan" required class="w-full border rounded px-3 py-2">
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
                <label for="bulan" class="block text-sm font-medium mb-1">Bulan</label>
                <select name="bulan" id="bulan" required class="w-full border rounded px-3 py-2">
                    @foreach (range(1, 12) as $bulan)
                        <option value="{{ $bulan }}">
                            {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label for="tahun" class="block text-sm font-medium mb-1">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ now()->year }}" required
                    class="w-full border rounded px-3 py-2">
            </div>

            {{-- Meter Awal --}}
            <div class="mb-4">
                <label for="meter_awal" class="block text-sm font-medium mb-1">Meter Awal</label>
                <input type="number" name="meter_awal" id="meter_awal" class="w-full border px-3 py-2 rounded"
                    required>
            </div>

            {{-- Meter Akhir --}}
            <div class="mb-4">
                <label for="meter_akhir" class="block text-sm font-medium mb-1">Meter Akhir</label>
                <input type="number" name="meter_akhir" id="meter_akhir" class="w-full border px-3 py-2 rounded"
                    required>
                <div id="meter_error" class="text-red-600 text-sm mt-1 hidden">
                    Meter akhir harus lebih besar dari meter awal
                </div>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-between items-center mt-6">
                <button type="button" onclick="closeCreateTagihanModal()"
                    class="text-gray-600 hover:underline">Batal</button>
                <button type="submit" id="submitBtn"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const meterAwal = document.getElementById('meter_awal');
        const meterAkhir = document.getElementById('meter_akhir');
        const meterError = document.getElementById('meter_error');
        const submitBtn = document.getElementById('submitBtn');

        function validateMeter() {
            const awal = parseFloat(meterAwal.value) || 0;
            const akhir = parseFloat(meterAkhir.value) || 0;

            if (meterAwal.value && meterAkhir.value && akhir <= awal) {
                meterError.classList.remove('hidden');
                meterAkhir.classList.add('border-red-500');
                meterAkhir.classList.remove('border-gray-300');
                submitBtn.disabled = true;
                submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                return false;
            } else {
                meterError.classList.add('hidden');
                meterAkhir.classList.remove('border-red-500');
                meterAkhir.classList.add('border-gray-300');
                submitBtn.disabled = false;
                submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                return true;
            }
        }

        meterAwal.addEventListener('input', validateMeter);
        meterAkhir.addEventListener('input', validateMeter);

        // Validasi saat form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            if (!validateMeter()) {
                e.preventDefault();
                alert('Meter akhir harus lebih besar dari meter awal!');
            }
        });
    });
</script>
