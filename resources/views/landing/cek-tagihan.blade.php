@extends('layouts.index')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">

        <!-- BAGIAN 1: Form Input KWH -->
        <h2 class="text-2xl font-bold text-blue-700 mb-2 text-center">Cek Tagihan Listrik</h2>
        <p class="text-gray-600 text-sm text-center mb-6">
            Periksa tagihan listrik Anda dengan mudah dan cepat. Masukkan nomor KWH untuk melihat detail tagihan. <br>
            <span class="text-xs italic text-gray-400">(Hanya tersedia untuk melihat informasi, pembayaran memerlukan akun.)</span>
        </p>

        <form action="{{ route('cek-tagihan') }}" method="GET" class="flex flex-col md:flex-row items-center gap-4 justify-center">
            <input type="text" name="kwh" placeholder="Masukkan nomor kWh"
                class="w-full md:w-2/3 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition">
                Cari Tagihan
            </button>
        </form>

        <!-- Jika sudah ada hasil pencarian -->
        @if(request('kwh'))
        <div class="mt-10 bg-gray-100 p-4 rounded-lg shadow-sm">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Hasil Pencarian Tagihan</h3>
            <p class="text-sm text-gray-600 mb-4">
                Berikut Daftar Tagihan dari Nomor kWh <span class="font-bold">{{ request('kwh') }}</span>
            </p>

            <!-- BAGIAN 2: Daftar Tagihan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($tagihanList as $tagihan)
                <div class="bg-white border rounded-lg p-4 shadow">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="text-blue-600 text-xl"><i class="fas fa-bolt"></i></div>
                        <span class="text-sm text-gray-500 font-medium">{{ \Carbon\Carbon::parse($tagihan->tanggal)->translatedFormat('F Y') }}</span>
                    </div>
                    <p class="text-gray-700 text-sm">#{{ $tagihan->invoice }}</p>
                    <p class="text-sm text-gray-600 mb-2">Pelanggan: <strong>{{ $tagihan->nama }}</strong></p>
                    @if ($tagihan->status == 'lunas')
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded">Sudah Lunas</span>
                    @else
                    <span class="inline-block bg-red-100 text-red-700 text-xs font-semibold px-3 py-1 rounded">Belum Lunas</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
