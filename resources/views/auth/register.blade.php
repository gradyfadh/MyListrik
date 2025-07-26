@extends('auth.index')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="bg-white shadow-lg rounded-xl overflow-hidden w-full max-w-5xl grid grid-cols-1 md:grid-cols-2">

        <!-- Kiri: Form Registrasi -->
        <div class="p-8">
            <h2 class="text-2xl font-bold text-[#ff654d] mb-1 text-center">🔌 Voltix</h2>
            <p class="text-center text-sm text-gray-500 mb-6">Buat akun baru untuk mulai mengelola tagihan listrik Anda</p>

            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Kolom kiri -->
                    <div>
                        <div class="mb-4">
                            <input type="text" name="name" placeholder="Nama Lengkap"
                                class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                        </div>

                        <div class="mb-4">
                            <input type="email" name="email" placeholder="Alamat Email"
                                class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                        </div>

                        <div class="mb-4">
                            <input type="text" name="phone" placeholder="Nomor Telepon"
                                class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                        </div>

                        <div class="mb-4">
                            <textarea name="address" rows="3" placeholder="Alamat Lengkap"
                                class="w-full rounded-lg px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]"></textarea>
                        </div>
                    </div>

                    <!-- Kolom kanan -->
                    <div>
                        <div class="mb-4">
                            <!-- <select name="tarif"
                                class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                                <option value="">-- Pilih Tarif Listrik --</option>
                                <option value="R1">R1 - Rumah Tangga</option>
                                <option value="R2">R2 - Rumah Tangga Menengah</option>
                                <option value="R3">R3 - Rumah Tangga Besar</option>
                                <option value="B1">B1 - Bisnis Kecil</option>
                                <option value="B2">B2 - Bisnis Sedang</option>
                                <option value="B3">B3 - Bisnis Besar</option>
                            </select> -->

                            <select name="tarif" class="...">
                                <option value="">-- Pilih Tarif --</option>
                                @foreach ($tarifs as $tarif)
                                <option value="{{ $tarif->kode_tarif }}">{{ $tarif->kode_tarif }} - {{ $tarif->daya }} Watt</option>
                                @endforeach
                            </select>

                        </div>

                        <div class="mb-4">
                            <input type="password" name="password" placeholder="Kata Sandi"
                                class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                        </div>

                        <div class="mb-4">
                            <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata Sandi"
                                class="w-full rounded-full px-4 py-2.5 bg-blue-50 text-sm border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff654d]">
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#ff654d] text-white py-2.5 mt-4 rounded-full font-semibold hover:bg-[#e14b3b] transition">
                    Daftar Sekarang
                </button>

                <div class="mt-4 flex justify-between text-sm">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-[#ff654d]">&larr; Kembali</a>
                    <a href="{{ route('login') }}" class="text-[#ff654d] hover:underline">Sudah punya akun? Login &rarr;</a>
                </div>
            </form>
        </div>

        <!-- Kanan: Branding -->
        <div class="bg-gradient-to-br from-[#ff654d] to-[#ff7e66] text-white flex flex-col justify-center items-center p-8">
            <div class="text-center">
                <div class="text-4xl font-bold mb-2">∞ Voltix</div>
                <p class="text-sm max-w-xs">
                    Pantau dan bayar tagihan listrik Anda dengan mudah dan aman.
                    Nikmati kenyamanan sistem pascabayar digital yang modern.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
