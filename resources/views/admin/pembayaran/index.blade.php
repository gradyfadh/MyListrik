@extends('admin.index')

@section('content')
    <div class="p-6 bg-white rounded-xl shadow-md">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Pembayaran</h1>
        </div>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <!-- Main Content Grid -->
        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Left Section: Filter -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Filter Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Filter Riwayat Pembayaran</h3>
                    <p class="text-gray-600 text-sm mb-6">Gunakan filter ini untuk menampilkan riwayat pembayaran berdasarkan
                        bulan dan tahun tertentu.</p>

                    <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="space-y-4">
                        <div class="grid md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <select name="tahun"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Semua Tahun</option>
                                    @for ($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}"
                                            {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                                <select name="bulan"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Semua Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                            {{ bulanIndo($i) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                    Filter
                                </button>
                                <div class="ml-2">
                                    <a href="{{ route('admin.pembayaran.index') }}"
                                        class="inline-flex items-center p-3 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                                        <i class="fa-solid fa-rotate-left"></i>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
            </div>

            <!-- Right Section: Summary -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Pemasukan</h3>
                    <p class="text-gray-600 text-sm mb-6">Pemasukan akan ditampilkan berdasarkan filter bulan dan tahun
                        yang dipilih.</p>

                    <div class="flex items-center gap-3">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <span class="text-2xl">📋</span>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-blue-600">
                                Rp {{ number_format($pembayarans->sum('total_bayar'), 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $pembayarans->count() }} Transaksi pada Tabel
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Card - Full Width -->
        <div class="mt-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">

                <div class="p-6">
                    <!-- Table Controls -->
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <select
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option>10</option>
                                    <option>25</option>
                                    <option>50</option>
                                </select>
                                <span class="text-sm text-gray-600">entries per page</span>
                            </div>

                            <div class="flex items-center gap-2">
                                <label class="text-sm text-gray-600">Search:</label>
                                <input type="text"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm w-64 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Cari nama pelanggan...">
                            </div>
                        </div>
                    </div>

                    <!-- Table - Full Width -->
                    <div class="overflow-x-auto border-2 border-gray-300 rounded-lg shadow-sm">
                        <table class="w-full text-sm border-collapse">
                            <thead class="bg-gray-50">
                                <tr class="border-b-2 border-gray-300">
                                    <th
                                        class="text-left py-4 px-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 min-w-[80px] border-r border-gray-300">
                                        # <span class="text-xs">▲</span>
                                    </th>
                                    <th
                                        class="text-left py-4 px-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 min-w-[200px] border-r border-gray-300">
                                        Nama Pelanggan <span class="text-xs">▼</span>
                                    </th>
                                    <th
                                        class="text-left py-4 px-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 min-w-[150px] border-r border-gray-300">
                                        Periode Tagihan
                                    </th>
                                    <th
                                        class="text-left py-4 px-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 min-w-[180px] border-r border-gray-300">
                                        Tanggal Pembayaran
                                    </th>
                                    <th
                                        class="text-left py-4 px-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 min-w-[150px] border-r border-gray-300">
                                        Total Bayar
                                    </th>
                                    <th
                                        class="text-left py-4 px-6 font-semibold text-gray-700 cursor-pointer hover:bg-gray-100 min-w-[150px]">
                                        Metode Pembayaran
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($pembayarans as $index => $pembayaran)
                                    <tr class="hover:bg-gray-50 transition-colors border-b border-gray-200">
                                        <td class="py-4 px-6 font-medium text-gray-900 border-r border-gray-300">
                                            {{ $pembayarans->firstItem() + $index }}</td>
                                        <td class="py-4 px-6 border-r border-gray-300">
                                            <div class="font-medium text-gray-900">
                                                {{ $pembayaran->pelanggan->nama_pelanggan ?? '-' }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $pembayaran->pelanggan->nomor_kwh ?? '-' }}</div>
                                        </td>
                                        <td class="py-4 px-6 border-r border-gray-300">
                                            <span
                                                class="bg-blue-100 text-blue-800 px-3 py-1 rounded-md text-sm font-medium">
                                                {{ bulanIndo($pembayaran->bulan_bayar) }}
                                                {{ date('Y', strtotime($pembayaran->tanggal_pembayaran)) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-gray-900 border-r border-gray-300">
                                            {{ date('l, d F Y', strtotime($pembayaran->tanggal_pembayaran)) }}
                                        </td>
                                        <td class="py-4 px-6 border-r border-gray-300">
                                            <span class="font-bold text-green-600 text-lg">
                                                Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if ($pembayaran->metodePembayaran)
                                                @php
                                                    // Tentukan jenis pembayaran berdasarkan kode
                                                    $kode = $pembayaran->metodePembayaran->kode;
                                                    $jenisPembayaran = match (true) {
                                                        in_array($kode, ['OVO', 'GOPAY', 'DANA', 'SHOPEEPAY'])
                                                            => 'E-Wallet',
                                                        in_array($kode, ['BCA', 'MANDIRI', 'BNI', 'BRI', 'BSI'])
                                                            => 'Bank',
                                                        $kode === 'QRIS' => 'QRIS',
                                                        default => 'Lainnya',
                                                    };

                                                    $metodeBadgeClass = match ($jenisPembayaran) {
                                                        'E-Wallet' => 'bg-purple-100 text-purple-800',
                                                        'Bank' => 'bg-blue-100 text-blue-800',
                                                        'QRIS' => 'bg-green-100 text-green-800',
                                                        default => 'bg-gray-100 text-gray-800',
                                                    };
                                                @endphp
                                                <span
                                                    class="{{ $metodeBadgeClass }} px-3 py-1 rounded-md text-sm font-medium">
                                                    {{ $pembayaran->metodePembayaran->nama }}
                                                </span>
                                            @else
                                                <span
                                                    class="bg-gray-100 text-gray-800 px-3 py-1 rounded-md text-sm font-medium">
                                                    Tidak Diketahui
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-16 h-16 mb-4 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                    </path>
                                                </svg>
                                                <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada data pembayaran
                                                </h3>
                                                <p class="text-gray-500">Belum ada data pembayaran lunas untuk periode yang
                                                    dipilih.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($pembayarans->hasPages())
                        <div class="mt-6
                                                    border-t border-gray-200 pt-6">
                            {{ $pembayarans->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
