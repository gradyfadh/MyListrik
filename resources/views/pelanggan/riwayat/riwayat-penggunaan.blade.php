@extends('pelanggan.layouts.index')

@section('content')
    <div class="bg-gray-100 min-h-screen px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl font-bold text-blue-800 mb-1 text-center">Riwayat Penggunaan Listrik</h1>
            <p class="text-gray-600 mb-6 text-center">Berikut adalah daftar riwayat penggunaan listrik Anda sebagai
                pelanggan.</p>

            <!-- Include Alert Component dengan Fixed Position -->
            <div class="fixed top-4 right-4 z-50 max-w-md">
                @include('components.alert')
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                {{-- Bagian Kiri: Riwayat Penggunaan --}}
                <div class="flex-1 space-y-4">
                    @forelse($penggunaans as $penggunaan)
                        {{-- Kartu Riwayat --}}
                        <div class="bg-white rounded-xl shadow p-6">
                            {{-- Header dengan bulan/tahun --}}
                            <div class="mb-4">
                                <h3 class="text-xl font-semibold text-gray-800">{{ bulanIndo($penggunaan->bulan) }}
                                    {{ $penggunaan->tahun }}</h3>
                            </div>

                            {{-- Content dalam 3 kolom --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                {{-- Kolom 1: Meter Awal-Akhir & Tarif --}}
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-base text-gray-600">Meter Awal - Akhir</p>
                                        <p class="text-lg font-semibold text-gray-800">
                                            {{ number_format($penggunaan->meter_awal, 0, ',', '.') }} -
                                            {{ number_format($penggunaan->meter_akhir, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base text-gray-600">Tarif per kWh</p>
                                        <p class="text-lg font-semibold text-gray-800">
                                            Rp
                                            {{ number_format($penggunaan->pelanggan->tarif->tarifperkwh ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Kolom 2: Jumlah Meter & Daya Listrik --}}
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-base text-gray-600">Jumlah Meter</p>
                                        <p class="text-lg font-semibold text-blue-600">
                                            {{ number_format($penggunaan->meter_akhir - $penggunaan->meter_awal, 0, ',', '.') }}
                                            kWh
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-base text-gray-600">Daya Listrik</p>
                                        <p class="text-lg font-semibold text-gray-800">
                                            {{ $penggunaan->pelanggan->tarif->daya ?? 'Tidak diketahui' }} VA
                                        </p>
                                    </div>
                                </div>

                                {{-- Kolom 3: Logo Petir & Tagihan --}}
                                <div
                                    class="flex items-center justify-center w-16 h-16 rounded-lg bg-blue-100 text-blue-600 space-y-3">
                                    <i class="fa-solid fa-bolt-lightning text-3xl"></i>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="bg-white rounded-xl shadow p-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="ti ti-bolt text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Data Penggunaan</h3>
                            <p class="text-gray-600">Belum ada riwayat penggunaan listrik yang tercatat untuk akun Anda.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Bagian Kanan: Filter + Statistik --}}
                <div class="w-full lg:w-1/3 space-y-4">
                    {{-- Filter --}}
                    <div class="bg-white p-5 rounded-xl shadow">
                        <h4 class="font-semibold text-gray-800 mb-3">Filter Riwayat Penggunaan</h4>
                        <form method="GET" action="{{ route('riwayat-penggunaan') }}" class="space-y-3">
                            <select name="bulan"
                                class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ bulanIndo($i) }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun"
                                class="w-full border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Tahun</option>
                                @for ($year = date('Y'); $year >= 2020; $year--)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Filter
                                </button>
                                <a href="{{ route('riwayat-penggunaan') }}"
                                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>

                    {{-- Statistik --}}
                    <div class="bg-white p-5 rounded-xl shadow">
                        <h4 class="font-semibold text-gray-800 mb-3">Statistik Penggunaan</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="text-sm text-gray-600">Total Bulan</span>
                                <span class="font-semibold text-blue-600">{{ $penggunaans->count() }}</span>
                            </div>
                            @if ($penggunaans->count() > 0)
                                <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                    <span class="text-sm text-gray-600">Total kWh</span>
                                    <span class="font-semibold text-green-600">
                                        {{ number_format($penggunaans->sum(function ($p) {return $p->meter_akhir - $p->meter_awal;}),0,',','.') }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-orange-50 rounded-lg">
                                    <span class="text-sm text-gray-600">Rata-rata kWh</span>
                                    <span class="font-semibold text-orange-600">
                                        {{ number_format($penggunaans->avg(function ($p) {return $p->meter_akhir - $p->meter_awal;}),0,',','.') }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Chart Placeholder --}}
                    <div class="bg-white p-5 rounded-xl shadow">
                        <h4 class="font-semibold text-gray-800 mb-3">Grafik Penggunaan</h4>
                        @if ($penggunaans->count() > 0)
                            <div class="space-y-2">
                                @foreach ($penggunaans->take(6) as $penggunaan)
                                    @php
                                        $usage = $penggunaan->meter_akhir - $penggunaan->meter_awal;
                                        $maxUsage = $penggunaans->max(function ($p) {
                                            return $p->meter_akhir - $p->meter_awal;
                                        });
                                        $percentage = $maxUsage > 0 ? ($usage / $maxUsage) * 100 : 0;
                                    @endphp
                                    <div class="flex items-center text-xs">
                                        <span class="w-12 text-gray-600">{{ bulanIndo($penggunaan->bulan) }}</span>
                                        <div class="flex-1 mx-2 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%">
                                            </div>
                                        </div>
                                        <span
                                            class="w-12 text-right text-gray-600">{{ number_format($usage, 0, ',', '.') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="w-full h-32 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                                Tidak ada data untuk ditampilkan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
