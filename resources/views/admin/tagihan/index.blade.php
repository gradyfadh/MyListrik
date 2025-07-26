@extends('admin.index')

@section('content')
    <div class="p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-4">Data Tagihan</h2>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        {{-- Filter --}}
        <div class="bg-white p-4 rounded shadow mb-6">
            <form method="GET" action="{{ route('admin.tagihan.index') }}"
                class="flex flex-col md:flex-row gap-4 md:items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Status Pembayaran</label>
                    <select name="status" class="w-full border px-3 py-2 rounded">
                        <option value="">-- Semua --</option>
                        <option value="Sudah Lunas" {{ request('status') == 'Sudah Lunas' ? 'selected' : '' }}>Sudah Lunas
                        </option>
                        <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas
                        </option>
                        <option value="Menunggu Verifikasi"
                            {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Nomor kWh</label>
                    <input type="text" name="nomor_kwh" placeholder="Masukkan Nomor KWH"
                        value="{{ request('nomor_kwh') }}" class="w-full border px-3 py-2 rounded">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Terapkan</button>
                    <a href="{{ route('admin.tagihan.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Reset</a>
                </div>
            </form>
        </div>

        {{-- Tabel --}}
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Nama Pelanggan</th>
                        <th class="px-4 py-2 border">Periode Tagihan</th>
                        <th class="px-4 py-2 border">Jumlah Meter</th>
                        <th class="px-4 py-2 border">Status</th>
                        <th class="px-4 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagihans as $index => $tagihan)
                        <tr>
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $tagihan->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ bulanIndo($tagihan->bulan) }} - {{ $tagihan->tahun }}</td>
                            <td class="px-4 py-2 border">{{ $tagihan->jumlah_meter }} kWh</td>
                            <td class="px-4 py-2 border">
                                <span
                                    class="px-2 py-1 rounded text-white text-xs
                            @if ($tagihan->status == 'Sudah Lunas') bg-green-500
                            @elseif ($tagihan->status == 'Menunggu Verifikasi') bg-yellow-500
                            @else bg-red-500 @endif">
                                    {{ $tagihan->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <div class="flex justify-center gap-2">
                                    @if ($tagihan->status === 'Menunggu Verifikasi')
                                        {{-- Tombol Konfirmasi (buka modal) --}}
                                        <button type="button"
                                            class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500"
                                            title="Konfirmasi" onclick="openModal('{{ $tagihan->id_tagihan }}')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        @include('admin.tagihan.konfirmasi-modal', ['tagihan' => $tagihan])
                                    @endif
                                    @if ($tagihan->status === 'Sudah Lunas')
                                        {{-- Tombol Cetak (stream PDF) --}}
                                        <a href="{{ route('admin.tagihan.print', $tagihan->id_tagihan) }}" target="_blank"
                                            class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600"
                                            title="Cetak Struk PDF">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    @endif
                                    @if ($tagihan->status === 'Belum Lunas')
                                        {{-- Tombol Bayar --}}
                                        <a href="{{ route('admin.tagihan.bayar', $tagihan->id_tagihan) }}"
                                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"
                                            title="Bayar">
                                            <i class="fa fa-wallet"></i>
                                        </a>
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.tagihan.destroy', $tagihan->id_tagihan) }}"
                                        method="POST" onsubmit="return confirm('Hapus tagihan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data tagihan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
