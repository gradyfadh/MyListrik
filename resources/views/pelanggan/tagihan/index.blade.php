@extends('pelanggan.layouts.index')


@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-blue-700">Tagihan Listrik</h1>
            <p class="text-gray-600 mt-2">Berikut adalah daftar tagihan listrik Anda.</p>
        </div>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <form method="GET" action="{{ route('pelanggan.tagihan') }}" class="w-full max-w-3xl mx-auto mb-8">
            <div class="flex items-center gap-3">

                <span
                    class="shrink-0 px-6 py-2.5 bg-white rounded-lg text-sm font-semibold
                   text-gray-700 border border-gray-200 shadow-sm">
                    Filter Tagihan
                </span>

                <select name="status" onchange="this.form.submit()"
                    class="flex-1 px-6 py-2.5 bg-white rounded-lg text-sm border border-gray-200 shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Semua" {{ ($selectedStatus ?? 'Semua') == 'Semua' ? 'selected' : '' }}>Semua Status
                    </option>
                    <option value="Belum Lunas" {{ ($selectedStatus ?? '') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas
                    </option>
                    </option>
                    <option value="Menunggu Verifikasi"
                        {{ ($selectedStatus ?? '') == 'Menunggu Verifikasi' ? 'selected' : '' }}>
                        Menunggu Verifikasi
                    </option>
                </select>

                <a href="{{ route('pelanggan.tagihan') }}"
                    class="shrink-0 px-6 py-2.5 bg-white rounded-lg text-sm font-semibold text-blue-600
                      border border-gray-200 shadow-sm hover:bg-blue-50 transition">
                    Reset
                </a>

            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($tagihans as $tagihan)
                @php
                    $isLunas = $tagihan->status === 'Sudah Lunas';
                    $statusClr = $isLunas ? 'text-green-600' : 'text-red-600';
                    $showBayar = $tagihan->status === 'Belum Lunas';
                    $subtotal = $tagihan->jumlah_meter * ($tagihan->pelanggan->tarif->tarifperkwh ?? 0);
                    $totalTagihan = $subtotal;
                    $total = number_format($totalTagihan, 0, ',', '.');
                @endphp

                <div class="relative overflow-hidden rounded-xl shadow-lg">

                    <div class="border-b">
                        <h2 class="text-xl font-bold p-6 pb-4">
                            {{ bulanIndo($tagihan->bulan) }} {{ $tagihan->tahun }}
                        </h2>
                    </div>

                    <div class="relative p-6 pb-4 bg-white">

                        <div
                            class="absolute top-4 right-4
                            flex items-center justify-center
                            w-15 h-15 rounded-lg bg-blue-100 text-blue-600">
                            <i class="fa-solid fa-bolt-lightning text-3xl"></i>
                        </div>

                        <div class="leading-tight mb-3">
                            <p class="text-[11px] text-gray-500">No Invoice</p>
                            <p class="text-md font-bold text-gray-800">{{ $tagihan->no_invoice }}</p>
                        </div>


                        <p class="text-xs text-gray-500">Pelanggan</p>
                        <p class="text-md font-bold mb-3">{{ $tagihan->pelanggan->nama_pelanggan }}</p>

                        <p class="text-xs text-gray-500">Status Pembayaran</p>
                        <div
                            class="inline-block px-3 py-1 rounded-md text-xs font-semibold
                            {{ $tagihan->status === 'Sudah Lunas'
                                ? 'bg-green-100 text-green-700'
                                : ($tagihan->status === 'Menunggu Verifikasi'
                                    ? 'bg-yellow-100 text-yellow-700'
                                    : 'bg-red-100 text-red-700') }}">
                            {{ $tagihan->status }}
                        </div>
                    </div>


                    <div class="h-12 bg-gradient-to-b from-white/80 to-gray-50"></div>

                    <div class="bg-white pt-4 border-t">
                        <div class="flex items-baseline justify-between px-6 pb-3">
                            <div class="text-md font-bold">Total Tagihan</div>
                            <div class="text-blue-700 text-lg font-bold">Rp {{ $total }}</div>
                        </div>
                        <p class="px-6 text-[11px] text-gray-500 mb-4">Belum Termasuk Biaya Admin</p>

                        @if ($showBayar)
                            <a href="{{ route('bayar.create', $tagihan->id_tagihan) }}"
                                class="block mx-6 mb-6 rounded-full bg-blue-600 hover:bg-blue-700
                      text-white text-sm font-bold text-center py-2">
                                Bayar Sekarang
                            </a>
                        @endif
                    </div>

                    <span class="absolute inset-y-0 left-0 w-[2px] bg-slate-200/80"></span>
                    <span class="absolute inset-y-0 right-0 w-[2px] bg-slate-200/80"></span>
                </div>
            @endforeach
        </div>

    </div>
@endsection
