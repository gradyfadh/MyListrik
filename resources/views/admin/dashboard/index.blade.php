    @extends('admin.index')

    @section('content')
        <!-- Statistik Ringkasan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg p-4 shadow flex items-center space-x-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="ti ti-user-plus text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-blue-700">Pelanggan Baru <span
                            class="text-sm font-normal text-gray-500">(Menunggu
                            Konfirmasi)</span></h4>
                    <p class="text-2xl font-bold text-gray-80">{{ $jumlahMenunggu }}
                        <span class="text-sm font-normal text-gray-500">
                            Pelanggan Menunggu Konfirmasi
                        </span>
                    </p>
                </div>
            </div>
            <div class="bg-white
                            rounded-lg p-4 shadow flex items-center space-x-4">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="ti ti-users text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-blue-700">Pelanggan Aktif</h4>
                    <p class="text-2xl font-bold text-gray-80">{{ $jumlahAktif }}
                        <span class="text-sm font-normal text-gray-500">
                            Pelanggan Dengan Status Aktif
                        </span>
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-4 shadow flex items-center space-x-4">
                <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full">
                    <i class="ti ti-tag-starred text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-xl font-semibold text-blue-700">Jumlah Tarif</h4>
                    <p class="text-2xl font-bold text-gray-80">{{ $jumlahTarif }}
                        <span class="text-sm font-normal text-gray-500">
                            Tarif Listrik Tersedia
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Grid Statistik Tambahan -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            {{--  KARTU  --}}
            <div class="bg-white rounded-lg p-6 shadow flex flex-col"> {{-- ⬅️ flex‑col --}}
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xl font-semibold text-blue-700">Penggunaan Listrik</h4>
                    <span class="text-sm font-normal text-gray-500">Tahun ini</span>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center space-y-3 text-center">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="ti ti-bolt text-2xl"></i>
                    </div>

                    @php
                        $penggunaans = \App\Models\Penggunaan::all();
                        $totalPenggunaan = $penggunaans->sum('meter_akhir') - $penggunaans->sum('meter_awal');
                        $jumlahPemakaian = $penggunaans->count();
                    @endphp

                    <p class="text-2xl font-bold text-gray-800">
                        {{ $totalPenggunaan ?: 0 }} <span class="text-base font-normal">kWh</span>
                    </p>
                    <p class="text-md text-green-600">
                        {{ $jumlahPemakaian ?: 0 }} Pemakaian Listrik
                    </p>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="bg-white rounded-lg p-6 shadow flex flex-col">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xl font-semibold text-blue-700">Metode Pembayaran</h4>
                    <span class="text-sm font-normal text-gray-500">Aktif</span>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center space-y-3 text-center">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                        <i class="ti ti-credit-card text-2xl"></i>
                    </div>

                    @php
                        $metodePembayaranAktif = \App\Models\MetodePembayaran::where('is_aktif', true)->count();
                        $metodePembayaranTotal = \App\Models\MetodePembayaran::count();
                    @endphp

                    <p class="text-2xl font-bold text-gray-800">
                        {{ $metodePembayaranAktif ?: 0 }}
                    </p>
                    <p class="text-md text-purple-600">
                        dari {{ $metodePembayaranTotal ?: 0 }} Total Metode
                    </p>
                </div>
            </div>



            <!-- Pemasukan -->
            <div class="bg-white rounded-lg p-6 shadow flex flex-col">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-xl font-semibold text-blue-700">Pemasukan</h4>
                    <span class="ttext-sm font-normal text-gray-500">Tahun ini</span>
                </div>
                <div class="flex-1 flex flex-col items-center justify-center space-y-3 text-center">
                    <div class="bg-green-100 text-green-600 p-2 rounded">
                        <span class="text-xl font-bold">Rp</span>
                    </div>
                    <div>
                        @php
                            // Ambil tagihan yang statusnya 'Sudah lunas'
                            $tagihanLunas = \App\Models\Tagihan::where('status', 'Sudah Lunas')->get();
                            $tagihanIds = $tagihanLunas->pluck('id_tagihan');

                            // Ambil pembayaran berdasarkan tagihan yang lunas
                            $pembayarans = \App\Models\Pembayaran::whereIn('id_tagihan', $tagihanIds)->get();
                            $totalPemasukan = $pembayarans->sum('total_bayar');
                            $jumlahTransaksi = $pembayarans->count();
                        @endphp
                        <div class="text-2xl font-bold text-gray-800">
                            Rp {{ number_format($totalPemasukan ?: 0, 0, ',', '.') }}
                        </div>
                        <div class="text-md text-green-600">
                            {{ $jumlahTransaksi ?: '0' }} Transaksi Pembayaran
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Tagihan -->
            <div class="bg-white rounded-lg p-6 shadow">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xl font-semibold text-blue-700">Status Tagihan</h4>
                    <span class="text-sm font-normal text-gray-500">Tahun ini</span>
                </div>

                @php
                    // Ambil jumlah tagihan per-status
                    $belumLunas = \App\Models\Tagihan::where('status', 'Belum Lunas')->count();
                    $menungguVerifikasi = \App\Models\Tagihan::where('status', 'Menunggu Verifikasi')->count();
                    $lunas = \App\Models\Tagihan::where('status', 'Sudah Lunas')->count();

                    $totalTagihan = $belumLunas + $menungguVerifikasi + $lunas;
                    $dataSet = [$belumLunas, $menungguVerifikasi, $lunas];
                @endphp

                <!-- Chart Container -->
                <div class="relative flex justify-center mb-6">
                    <div class="relative">
                        <canvas id="donutChart" width="120" height="120"></canvas>
                        <!-- Center Text -->
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                            <div class="text-lg font-bold text-gray-800" id="totalTagihan">{{ $totalTagihan }}</div>
                            <div class="text-xs text-gray-500">Total Tagihan</div>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="space-y-2 text-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-red-500 rounded-full flex-shrink-0"></span>
                            <span class="text-gray-700">Belum Lunas</span>
                        </div>
                        <span class="font-medium text-gray-800" id="belumCount">{{ $belumLunas }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-yellow-400 rounded-full flex-shrink-0"></span>
                            <span class="text-gray-700">Menunggu Verifikasi</span>
                        </div>
                        <span class="font-medium text-gray-800" id="menungguCount">{{ $menungguVerifikasi }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full flex-shrink-0"></span>
                            <span class="text-gray-700">Lunas</span>
                        </div>
                        <span class="font-medium text-gray-800" id="lunasCount">{{ $lunas }}</span>
                    </div>
                </div>
            </div>

        </div>
    @endsection

    @push('scripts')
        <script>
            window.addEventListener('load', () => {
                const ctx = document.getElementById('donutChart');

                if (!ctx) return; // guard

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Belum Lunas', 'Menunggu Verifikasi', 'Lunas'],
                        datasets: [{
                            data: @json([$belumLunas, $menungguVerifikasi, $lunas]),
                            backgroundColor: ['#EF4444', '#FACC15', '#10B981'],
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        responsive: false // ↔ karena width/height fixed
                    }
                });

                // Perbarui teks & legend kecil
                document.getElementById('totalTagihan').textContent = {{ $totalTagihan }};
                document.getElementById('belumCount').textContent = {{ $belumLunas }};
                document.getElementById('menungguCount').textContent = {{ $menungguVerifikasi }};
                document.getElementById('lunasCount').textContent = {{ $lunas }};
            });
        </script>
    @endpush
