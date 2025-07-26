@extends('admin.index')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-bold mb-4">Konfirmasi Pelanggan Baru</h2>

        <!-- Include Alert Component dengan Fixed Position -->
        <div class="fixed top-4 right-4 z-50 max-w-md">
            @include('components.alert')
        </div>

        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="py-2 px-4 border">No. KWH</th>
                    <th class="py-2 px-4 border">Nama</th>
                    <th class="py-2 px-4 border">Email</th>
                    <th class="py-2 px-4 border">No. Telp</th>
                    <th class="py-2 px-4 border">Alamat</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelangganWaiting as $pelanggan)
                    <tr class="border-t">
                        <td class="py-2 px-4 border">{{ $pelanggan->nomor_kwh }}</td>
                        <td class="py-2 px-4 border">{{ $pelanggan->nama_pelanggan }}</td>
                        <td class="py-2 px-4 border">{{ $pelanggan->email }}</td>
                        <td class="py-2 px-4 border ">{{ $pelanggan->no_telp_formatted }}</td>
                        <td class="py-2 px-4 border">{{ $pelanggan->alamat }}</td>
                        <td class="py-2 px-4 border">
                            <form action="{{ route('admin.konfirmasi.submit', $pelanggan->id_pelanggan) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">Konfirmasi</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada pelanggan yang menunggu
                            konfirmasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
