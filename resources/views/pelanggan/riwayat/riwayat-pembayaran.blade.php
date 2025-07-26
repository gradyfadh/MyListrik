@extends('pelanggan.layouts.index')

@section('content')
    <div class="bg-gray-100 min-h-screen px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold text-center text-blue-800 mb-2">Riwayat Pembayaran Listrik</h2>
            <p class="text-center text-gray-600 mb-8">Berikut adalah daftar riwayat pembayaran listrik Anda sebagai
                pelanggan.</p>

            <!-- Include Alert Component dengan Fixed Position -->
            <div class="fixed top-4 right-4 z-50 max-w-md">
                @include('components.alert')
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                {{-- Payment History Cards - Left Column (2/3 width) --}}
                <div class="lg:col-span-2 space-y-4">
                    @forelse($pembayarans as $pembayaran)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            {{-- Header with Month and Action Buttons --}}
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ bulanIndo($pembayaran->bulan_bayar) }}
                                        {{ $pembayaran->tagihan->tahun }}</h3>
                                </div>
                            </div>

                            {{-- Payment Details Grid --}}
                            <div class="grid md:grid-cols-3 gap-x-8 gap-y-3 text-sm">
                                {{-- Left Column --}}
                                <div class="space-y-3">
                                    <div>
                                        <div class="text-gray-500 mb-1">Invoice</div>
                                        <div class="font-semibold text-gray-800">{{ $pembayaran->tagihan->no_invoice }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 mb-1">Nomor KWH</div>
                                        <div class="font-semibold text-gray-800">{{ $pembayaran->pelanggan->nomor_kwh }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 mb-1">Jumlah Meter</div>
                                        <div class="font-semibold text-gray-800">
                                            {{ number_format($pembayaran->tagihan->jumlah_meter) }} kWh</div>
                                    </div>
                                </div>

                                {{-- Middle Column --}}
                                <div class="space-y-3">
                                    <div>
                                        <div class="text-gray-500 mb-1">Metode Pembayaran</div>
                                        <div class="font-semibold text-gray-800">Transfer</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 mb-1">Biaya Admin</div>
                                        <div class="font-semibold text-gray-800">Rp
                                            {{ number_format($pembayaran->biaya_admin, 0, ',', '.') }}</div>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 mb-1">Total Bayar</div>
                                        <div class="font-bold text-blue-600 text-base">Rp
                                            {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</div>
                                    </div>
                                </div>

                                {{-- Right Column --}}
                                <div class="space-y-3">
                                    <div>
                                        <div class="text-gray-500 mb-1">Status Pembayaran</div>
                                        <div class="flex items-center gap-2">
                                            @php
                                                $status = $pembayaran->tagihan->status;

                                                if ($status === 'Sudah Lunas') {
                                                    $statusText = 'Sudah Lunas';
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    $verifikasiText = 'Terverifikasi';
                                                } elseif ($status === 'Menunggu Verifikasi') {
                                                    $statusText = 'Menunggu Verifikasi';
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    $verifikasiText = 'Belum Terverifikasi';
                                                } else {
                                                    $statusText = 'Belum Lunas';
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    $verifikasiText = 'Belum Dibayar';
                                                }
                                            @endphp

                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold {{ $statusClass }}">
                                                @if ($statusText === 'Lunas')
                                                    ✓
                                                @endif{{ $statusText }}
                                            </span>
                                            <span class="text-gray-600 text-xs">- {{ $verifikasiText }}</span>
                                            <span class="text-blue-500 text-xs"><i
                                                    class="fa-solid fa-circle-check"></i></span>
                                        </div>
                                        <div class="flex flex-col gap-2 pt-6">
                                            @if ($pembayaran->bukti_pembayaran)
                                                <button
                                                    onclick="showBuktiModal('{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}', '{{ $pembayaran->id_pembayaran }}')"
                                                    class="border border-blue-600 text-blue-600 px-4 py-2 rounded-md text-sm hover:bg-blue-50 transition-colors min-w-32 text-center">
                                                    📄 Lihat Bukti
                                                </button>
                                            @else
                                                <span
                                                    class="border border-gray-300 text-gray-400 px-4 py-2 rounded-md text-sm min-w-32 text-center cursor-not-allowed">
                                                    📄 Tidak Ada Bukti
                                                </span>
                                            @endif

                                            @if ($pembayaran->tagihan->status === 'Sudah Lunas')
                                                <a href="{{ route('pembayaran.print-struk', $pembayaran->id_pembayaran) }}"
                                                    target="_blank"
                                                    class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 transition-colors text-center min-w-32">
                                                    �️ Cetak Struk
                                                </a>
                                            @else
                                                <span
                                                    class="bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm text-center min-w-32 cursor-not-allowed">
                                                    �️ Struk Belum Tersedia
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white rounded-lg shadow p-8 text-center">
                            <div class="text-gray-400 mb-4">
                                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pembayaran Lunas</h3>
                            <p class="text-gray-500">Anda belum memiliki riwayat pembayaran yang telah lunas sesuai dengan
                                filter yang
                                dipilih.</p>
                        </div>
                    @endforelse

                    {{-- Pagination --}}
                    @if ($pembayarans->hasPages())
                        <div class="bg-white rounded-lg shadow p-4">
                            {{ $pembayarans->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>

                {{-- Right Sidebar --}}
                <div class="space-y-6">
                    {{-- Filter Section --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold mb-4 text-gray-800">Filter Riwayat Pembayaran</h4>
                        <form method="GET" class="space-y-4">
                            <div>
                                <select name="bulan"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="all"
                                        {{ request('bulan') == 'all' || !request('bulan') ? 'selected' : '' }}>Semua Bulan
                                    </option>
                                    @foreach ($availableMonths as $month)
                                        <option value="{{ $month }}"
                                            {{ request('bulan') == $month ? 'selected' : '' }}>
                                            {{ bulanIndo($month) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select name="tahun"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                                    <option value="all"
                                        {{ request('tahun') == 'all' || !request('tahun') ? 'selected' : '' }}>Semua Tahun
                                    </option>
                                    @foreach ($availableYears as $year)
                                        <option value="{{ $year }}"
                                            {{ request('tahun') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-4 gap-3">
                                <button type="submit"
                                    class=" col-span-3 bg-blue-600 text-white py-3 rounded-lg text-sm hover:bg-blue-700 transition-colors font-medium">
                                    Filter
                                </button>
                                <a href="{{ route('riwayat-pembayaran') }}"
                                    class="bg-gray-600 text-white py-3 rounded-lg text-sm hover:bg-gray-700 transition-colors font-medium text-center">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Payment Chart Section --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h4 class="text-lg font-semibold mb-4 text-gray-800">Grafik Pembayaran</h4>
                        <div class="relative">
                            <canvas id="paymentChart" width="400" height="200" class="w-full"></canvas>
                        </div>

                        {{-- Chart legend --}}
                        <div class="mt-4 text-center">
                            <span class="text-xs text-gray-500">Pembayaran Bulanan (Rupiah)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal untuk Bukti Pembayaran --}}
    <div id="buktiModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center"
        style="display: none;">
        <div class="bg-white rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-gray-800">Bukti Pembayaran</h3>
                <button onclick="closeBuktiModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div class="text-center">
                <img id="buktiImage" src="" alt="Bukti Pembayaran"
                    class="max-h-96 max-w-full mx-auto rounded-lg shadow-md mb-4">
                <div class="flex gap-3 justify-center">
                    <button onclick="closeBuktiModal()"
                        class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                        Tutup
                    </button>
                    <a id="downloadBukti" href="#" download
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        📥 Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart.js untuk grafik pembayaran
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('paymentChart').getContext('2d');

            // Prepare data from PHP
            @php
                $chartData = $pembayarans
                    ->groupBy(function ($item) {
                        return $item->bulan_bayar . '-' . ($item->tagihan->tahun ?? date('Y'));
                    })
                    ->map(function ($group) {
                        $firstItem = $group->first();
                        return [
                            'periode' => \Carbon\Carbon::create($firstItem->tagihan->tahun ?? date('Y'), $firstItem->bulan_bayar, 1)->format('M Y'),
                            'total' => $group->sum('total_bayar'),
                            'bulan' => $firstItem->bulan_bayar,
                            'tahun' => $firstItem->tagihan->tahun ?? date('Y'),
                        ];
                    })
                    ->sortBy(function ($item) {
                        return $item['tahun'] . '-' . str_pad($item['bulan'], 2, '0', STR_PAD_LEFT);
                    })
                    ->take(12)
                    ->values();
            @endphp

            const chartData = @json($chartData);

            if (chartData.length === 0) {
                // Tampilkan pesan jika tidak ada data
                ctx.canvas.style.display = 'none';
                const parentDiv = ctx.canvas.parentNode;
                parentDiv.innerHTML = `
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-chart-bar text-4xl mb-3 opacity-50"></i>
                        <p>Belum ada data pembayaran untuk ditampilkan</p>
                    </div>
                `;
                return;
            }

            const labels = chartData.map(item => item.periode);
            const data = chartData.map(item => item.total);

            const paymentChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Pembayaran',
                        data: data,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // blue-600
                            'rgba(99, 102, 241, 0.8)', // indigo-500
                            'rgba(139, 92, 246, 0.8)', // violet-500
                            'rgba(168, 85, 247, 0.8)', // purple-500
                            'rgba(236, 72, 153, 0.8)', // pink-500
                            'rgba(239, 68, 68, 0.8)', // red-500
                            'rgba(34, 197, 94, 0.8)', // green-500
                            'rgba(251, 146, 60, 0.8)', // orange-500
                            'rgba(245, 158, 11, 0.8)', // amber-500
                            'rgba(14, 165, 233, 0.8)', // sky-500
                            'rgba(168, 85, 247, 0.8)', // purple-500
                            'rgba(219, 39, 119, 0.8)' // pink-600
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(99, 102, 241, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(168, 85, 247, 1)',
                            'rgba(236, 72, 153, 1)',
                            'rgba(239, 68, 68, 1)',
                            'rgba(34, 197, 94, 1)',
                            'rgba(251, 146, 60, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(14, 165, 233, 1)',
                            'rgba(168, 85, 247, 1)',
                            'rgba(219, 39, 119, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 4,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            callbacks: {
                                label: function(context) {
                                    return 'Total: Rp ' + new Intl.NumberFormat('id-ID').format(context
                                        .parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0,
                                        notation: 'compact',
                                        compactDisplay: 'short'
                                    }).format(value);
                                },
                                font: {
                                    size: 10
                                },
                                color: '#6B7280'
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                },
                                color: '#6B7280'
                            },
                            grid: {
                                display: false
                            }
                        }
                    },
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 5
                        }
                    }
                }
            });

            // Set chart height
            ctx.canvas.parentNode.style.height = '250px';
        });

        function showBuktiModal(imageUrl, pembayaranId) {
            document.getElementById('buktiImage').src = imageUrl;
            document.getElementById('downloadBukti').href = '/pelanggan/pembayaran/' + pembayaranId + '/download-bukti';
            const modal = document.getElementById('buktiModal');
            modal.style.display = 'flex';
        }

        function closeBuktiModal() {
            const modal = document.getElementById('buktiModal');
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        document.getElementById('buktiModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBuktiModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeBuktiModal();
            }
        });
    </script>
@endsection
