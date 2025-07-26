@extends('admin.index')

@section('content')
    <!-- Include Alert Component dengan Fixed Position -->
    <div class="fixed top-4 right-4 z-50 max-w-md">
        @include('components.alert')
    </div>

    <div class="p-6 bg-white rounded-xl shadow-md">

        {{-- 🔍 Filter Penggunaan Listrik --}}
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-50 p-4 rounded border">
                <h3 class="font-bold text-lg text-gray-700 mb-2">Filter Penggunaan Listrik</h3>
                <p class="text-sm text-gray-500 mb-3">Gunakan filter untuk menampilkan data sesuai nomor KWH.</p>

                <form method="GET" action="{{ route('admin.penggunaan.index') }}"
                    class="flex flex-col md:flex-row md:items-center gap-2">
                    <div class="flex items-center gap-2 w-full">
                        <input type="text" name="nomor_kwh" placeholder="Nomor KWH"
                            class="border rounded px-3 py-2 text-sm w-full" value="{{ request('nomor_kwh') }}">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Terapkan</button>
                        <a href="{{ route('admin.penggunaan.index') }}"
                            class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">Reset</a>
                    </div>
                </form>
            </div>

            {{-- ➕ Tombol Tambah --}}
            <div class="bg-gray-50 p-4 rounded border flex flex-col justify-between">
                <h3 class="font-bold text-lg text-gray-700 mb-2">Tambah Penggunaan Listrik</h3>
                <p class="text-sm text-gray-500 mb-3">Tambahkan penggunaan listrik baru untuk pelanggan.</p>
                <button onclick="openCreateTagihanModal()"
                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 w-fit">
                    <i class="fa fa-plus mr-2"></i> Tambah Penggunaan Baru
                </button>
            </div>
        </div>

        {{-- 📊 Tabel Penggunaan Listrik --}}
        <div class="bg-white p-4 rounded border shadow-sm">
            <h3 class="font-bold text-lg text-gray-700 mb-3">Tabel Penggunaan Listrik</h3>
            <table id="tagihanTable" class="min-w-full text-sm borde pt-5">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="py-2 px-4 border">#</th>
                        <th class="py-2 px-4 border">Nama Pelanggan</th>
                        <th class="py-2 px-4 border">Bulan</th>
                        <th class="py-2 px-4 border">Tahun</th>
                        <th class="py-2 px-4 border">Meter Awal</th>
                        <th class="py-2 px-4 border">Meter Akhir</th>
                        <th class="py-2 px-4 border">Jumlah Meter</th>
                        <th class="py-2 px-4 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($penggunaans as $index => $penggunaan)
                        <tr>
                            <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                            <td class="py-2 px-4 border">{{ $penggunaan->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td class="py-2 px-4 border">
                                {{ \Carbon\Carbon::create()->month($penggunaan->bulan)->translatedFormat('F') }}</td>
                            <td class="py-2 px-4 border">{{ $penggunaan->tahun }}</td>
                            <td class="py-2 px-4 border">{{ $penggunaan->meter_awal }} kWh</td>
                            <td class="py-2 px-4 border">{{ $penggunaan->meter_akhir }} kWh</td>
                            <td class="py-2 px-4 border">{{ $penggunaan->meter_akhir - $penggunaan->meter_awal }} kWh</td>
                            <td class="py-2 px-4 border">
                                <div class="flex gap-2 justify-center">
                                    <button
                                        onclick="openEditTagihanModal({{ $penggunaan->id_penggunaan }}, '{{ $penggunaan->id_pelanggan }}', {{ $penggunaan->bulan }}, {{ $penggunaan->tahun }}, {{ $penggunaan->meter_awal }}, {{ $penggunaan->meter_akhir }})"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        <i class="fa fa-pen"></i>
                                    </button>
                                    <form action="{{ route('admin.penggunaan.destroy', $penggunaan->id_penggunaan) }}"
                                        method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Create Penggunaan --}}
    @include('admin.penggunaan.create-modal')

    {{-- Modal Edit Penggunaan --}}
    @include('admin.penggunaan.edit-modal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tagihanTable').DataTable({
                responsive: true
            });
        });

        // Functions for Create Modal
        function openCreateTagihanModal() {
            document.getElementById('createTagihanModal').classList.remove('hidden');
            document.getElementById('createTagihanModal').classList.add('flex');
        }

        function closeCreateTagihanModal() {
            document.getElementById('createTagihanModal').classList.remove('flex');
            document.getElementById('createTagihanModal').classList.add('hidden');
        }

        // Functions for Edit Modal
        function openEditTagihanModal(id, idPelanggan, bulan, tahun, meterAwal, meterAkhir) {
            // Set form action URL
            const editForm = document.getElementById('editTagihanForm');
            editForm.action = `/admin/penggunaan/${id}`;

            // Fill form data
            document.getElementById('edit_id_penggunaan').value = id;
            document.getElementById('edit_id_pelanggan').value = idPelanggan;
            document.getElementById('edit_bulan').value = bulan;
            document.getElementById('edit_tahun').value = tahun;
            document.getElementById('edit_meter_awal').value = meterAwal;
            document.getElementById('edit_meter_akhir').value = meterAkhir;

            // Show modal
            document.getElementById('editTagihanModal').classList.remove('hidden');
            document.getElementById('editTagihanModal').classList.add('flex');
        }

        function closeEditTagihanModal() {
            document.getElementById('editTagihanModal').classList.remove('flex');
            document.getElementById('editTagihanModal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const createModal = document.getElementById('createTagihanModal');
            const editModal = document.getElementById('editTagihanModal');

            if (event.target === createModal) {
                closeCreateTagihanModal();
            }
            if (event.target === editModal) {
                closeEditTagihanModal();
            }
        }
    </script>
@endpush
